 
 <h2>CHAT GLOBAL </h2>
 <div class="me">Non connecté</div>
   <section id="connect">
       <button type="button" id="connect-btn">SE CONNECTER</button>
   </section>
   
   <section id="chatroom" class="hide">
       <header>
            <h3>Utilisateurs connectés</h3>
            <ul class="user-list"></ul>
       </header>
        <main>
          <h3>Chatroom</h3> 
           <ul class="message-list"></ul>
            <input type="text" placeholder="message" id="message">
            <button type="button">ENVOYER</button> 
        </main>
        
   </section>
   
   <form action="" id="connect-form" class="hide">
      <label for="username">Username</label>
       <input type="text" id="username" placeholder='<?= $user->__get('username'); ?>'>
       <input type="submit" id="CONNECT">
   </form>