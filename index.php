<?php require('function.php'); ?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHPオブジェクト指向OP</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Acme|Sawarabi+Gothic&display=swap" rel="stylesheet">
</head>

<body>
  <section class="main">
    <?php if (empty($_SESSION)) { ?>
      <img src="https://img.pokemon-matome.net/img/img01/2057f58681e19daa0919cbbd5d3f99b1c160a0351450939793.jpg" class="wide">
      <form method="post">
        <input type="submit" name="start" value="ゲームスタート" class="start">
      </form>
    <?php } else { ?>
      <h1 class="title">POKEMON</h1>
      <section class="section">


        <div class="container">
          <div class="pic">
            <img src="<?php echo $_SESSION['monster']->getImg(); ?>">
          </div>
          <div class="info border">
            <h2><?php echo $_SESSION['monster']->getName(); ?> <span>Lv:35</span></h2>

            <p>HP: <?php echo $_SESSION['monster']->getHp(); ?><meter min="0" max="<?php echo $_SESSION['monster']->getmaxHp(); ?>" low="30" high="50" optimum="60" value="<?php echo $_SESSION['monster']->getHp(); ?>"></p>
          </div>
        </div>

        <div class="container">
          <div class="pic">
            <img src="<?php echo $_SESSION['player']->getImg(); ?>" alt="">
          </div>
          <div class="info border">
            <h2><?php echo $_SESSION['player']->getName(); ?> <span>Lv:70</span></h2>

            <p>HP： <?php echo $_SESSION['player']->getHp(); ?><meter min="0" max="<?php echo $_SESSION['player']->getmaxHp(); ?>" low="100" high="250" optimum="400" value="<?php echo $_SESSION['player']->getHp(); ?>"><?php echo $_SESSION['player']->getHp(); ?><meter></p>
          </div>
        </div>
      </section>

      <section class="section row">
        <div class="container border">
          <p><?php echo (!empty($_SESSION['history'])) ? $_SESSION['history'] : ''; ?></p>
        </div>
        <div class="content">
          <form method="post" class="form">
            <input type="submit" name="attack" value="たたかう" class="attack btn">
            <input type="submit" name="special" value="必殺技" class="btn">
            <input type="submit" name="recover" value="きずぐすり" class="btn">
            <input type="submit" name="escape" value="にげる" class="btn">
          </form>
        </div>
      </section>

      <p class="kocount border">倒したモンスター数：<span class="span"><?php echo $_SESSION['koCt']; ?> </span>体</p>
    <?php } ?>
  </section>
  </section>
</body>

</html>