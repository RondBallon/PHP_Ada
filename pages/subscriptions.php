<?php
          include '../config/head_header.php';
          include '../config/bdd.php';
        ?>
  <div id="wrapper">
    <aside>
      <img src="../img/user.jpg" alt="Portrait de l'utilisatrice" />
      <section>
        <h3>Présentation</h3>
        <p>Sur cette page vous trouverez la liste des personnes dont
          l'utilisatrice 
          n° <?php echo intval($_GET['user_id']) ?>
          suit les messages
        </p>

      </section>
    </aside>
    <main class='contacts'>
      <?php
      // Etape 1: récupérer l'id de l'utilisateur
      $userId = intval($_GET['user_id']);
      
      // Etape 3: récupérer le nom de l'utilisateur
      $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
      $lesInformations = $mysqli->query($laQuestionEnSql);
      // Etape 4: à vous de jouer
      //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 


      while ($subscriptions = $lesInformations->fetch_assoc()) {

      ?>
        <article>
          <img src="../img/user.jpg" alt="blason" />
          <h3><?php echo $subscriptions['alias'] ?></h3>
          <p><?php echo $subscriptions['id'] ?></p>
        </article>
      <?php } ?>
    </main>
  </div>
</body>

</html>