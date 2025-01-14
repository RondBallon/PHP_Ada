<?php
          //session_start();
          include '../config/bdd.php';
          include '../config/recog_session.php';
          include '../config/chooseHeader.php';
          include '../config/listAuthors.php';
          include '../config/listTags.php';    
?>
  <div id="wrapper">
   


    <aside>
      <?php
      /**
       * Etape 3: récupérer le nom de l'utilisateur
       */
      $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
      $lesInformations = $mysqli->query($laQuestionEnSql);
      $user = $lesInformations->fetch_assoc();
      //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
      //echo "<pre>" . print_r($user, 1) . "</pre>";
      ?>
      <img src="../img/user.jpg" alt="Portrait de l'utilisatrice" />
      <section>
        <h3>Bonjour <?php echo $user['alias'] ?> </h3>
        <p>Sur cette page tu trouveras tous les postes de utilisateur.ice(s) auquel tu es abonné.e
          (n° <?php echo $userId ?>)
        </p>

      </section>
    </aside>
    <main>
      <?php
      /**
       * Etape 3: récupérer tous les messages des abonnements
       */
      $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM followers 
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE followers.following_user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
      $lesInformations = $mysqli->query($laQuestionEnSql);
      if (! $lesInformations) {
        echo ("Échec de la requete : " . $mysqli->error);
      }

      /**
       * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
       * A vous de retrouver comment faire la boucle while de parcours...
       */
      while ($post = $lesInformations->fetch_assoc()) {
      ?>
        <article>
          <h3>
            <time><?php echo $post['created'] ?></time>
          </h3>
          <?php include '../config/displayAuthor.php' ?>
          <div>
            <p><?php echo $post['content'] ?></p>
          </div>
          <footer>
            <small>♥ <?php echo $post['like_number'] ?></small>
            <a href=""><?php include '../config/displayTags.php' ?></a>
          </footer>
        </article>
      <?php
      }
      ?>


    </main>
  </div>
</body>

</html>