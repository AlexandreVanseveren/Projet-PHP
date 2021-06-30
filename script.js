
$(document).ready(function() {
	$('button#connect-btn').on('click', function() {
        $('#connect-form').removeClass('hide');
    });
	
    $('#test').on('click', function() {
		console.log('ola');
		champions=getChampions();
    });
	
	function getChampions(champion){
		var concatenation = "http://ddragon.leagueoflegends.com/cdn/10.11.1/data/en_US/champion.json";
		$.get(concatenation)
		.done(function(rsp){
			$('img.champions').attr('src','http://ddragon.leagueoflegends.com/cdn/img/champion/splash/Yasuo_0.jpg');
			$('div.test').text(rsp.data.Yasuo.blurb);
		})
		.fail(function(rsp){
        console.log(rsp);
		});
	};
	
    $('#connect-form').on('submit', function(e) {
        e.preventDefault();
        $('#chatroom').removeClass('hide');
        $('#connect').addClass('hide');
        $(this).addClass('hide');
        initSSE($(this).find('input#username').val())
    });   
    
    $('button').on('click', function() {
		// on envoye en post 
       $.post('chat_intake.php', {text: $('input#message').val()}) 
        .done(function(rsp) {
            console.log('message sent')
        })
        .fail(function(err) {
            console.log('error on message send', err);
        });
		// on vide la variable
        $('input#message').val('');
    });
	
});





function initSSE (uname) {
	//on check si c est supportable
   if(window.EventSource){
        source = new EventSource("chatroom.php");
       connect(uname);
        $('.me').text(uname);
       var last_data = false;
        source.addEventListener("message", function(event) {
            console.log('message recieved');
            var data = JSON.parse(event.data);
            console.log(data);
            if(data.message != last_data && data.message != ""){
                var elem = $('<li></li>');
                elem.html('<span class="author">'+data.author+'</span><span class="message">'+data.message+'</span>');
                if(data.author == uname) {
                    elem.addClass('mine');
                }
                $('ul.message-list').append(elem);
            }
            last_data = data.message;       
        }); 
       
    } 
}

function connect(uname) {
    console.log('in connect');
    $.post('user_intake.php', {new: uname}, function() {
        console.log('waiting');
    }) 
    .done(function(rsp) {
        console.log('server recieved that im connected');
        console.log('now keeping alive');
        keepAlive(uname);
    })
    .fail(function(err) {
        console.log('server failed to recieve my connection', err);
    });
            
}

function keepAlive(uname) {
    var interv = setInterval(function() {
        $.post('user_intake.php', {alive: uname}) 
        .done(function(rsp) {
            console.log('server recieved that im alive', rsp)
            updateUserList(rsp, uname);
        })
        .fail(function(err) {
            console.log('server failed to recieve my alive', err);
        });
    }, 1500);
}

function updateUserList(rsp, uname) {
    var users = JSON.parse(rsp);
    console.log(users);
	//on vide ul.user-list
    $('ul.user-list').html('');
    $.each(users, function(k, user) {
        console.log(user.name); 
        if(user.name !== uname) {
            var $elem = $('<li></li>');
            $elem.html(user.name);
            $('ul.user-list').append($elem);
        }
    });
}
