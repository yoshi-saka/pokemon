<?php
session_start();
ini_set('log_errors', 'on');  //ログを取るか
ini_set('error_log', 'php.log');  //ログの出力ファイルを指定

// モンスター・プレイヤー格納
$monsters = array();
$players = array();

// 抽象クラス
class Creature
{
  protected $name;
  protected $hp;
  protected $img;
  protected $atMin;
  protected $atMax;

  public function setName($str)
  {
    $this->name = $str;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setHp($num)
  {
    $this->hp = $num;
  }
  public function getHp()
  {
    return $this->hp;
  }
  public function getImg()
  {
    return $this->img;
  }
  // 攻撃
  public function attack($target)
  {
    $attackPt = mt_rand($this->atMin, $this->atMax);
    // ４分の１の確率で1.５倍のダメージを与える
    if (!mt_rand(0, 3)) {
      $attackPt = $attackPt * 1.5;
      $attackPt = (int) $attackPt;
      History::set($this->getName() .'の破壊光線✨');
    }
    // 30以下ならば
    $target->setHp($target->getHp() - $attackPt);
    switch($attackPt){
      case $attackPt <= 30:
         History::set($attackPt . 'Pのダメージ！効果は今ひとつだ...');
      break;
      // 31~99以下ならば
      case $attackPt >= 31 && $attackPt  <= 99:
        History::set($attackPt . 'Pのダメージ！');
      break;
      // 100以上
      case $attackPt >= 100:
        History::set($attackPt . 'Pのダメージ！効果は抜群だ！！');
    }

  }
}
// プレイヤークラス
// リザードン
class Player extends Creature
{
  private $skill;
  public function __construct($name, $hp, $img, $atMin, $atMax, $skill, $maxHp)
  {
    $this->name = $name;
    $this->hp = $hp;
    $this->img = $img;
    $this->atMin = $atMin;
    $this->atMax = $atMax;
    $this->skill = $skill;
    $this->maxHp = $maxHp;
  }
  public function getSkill()
  {
    return $this->skill;
  }
  public function getmaxHp(){
    return $this->maxHp;
  }
  public function attack($target)
  {
    if (!mt_rand(0, 3)) {
      History::set($this->getName() . 'の火炎放射🔥');
      $target->setHp($target->getHp() - $this->skill);
      History::set($this->skill . 'Pのダメージ！急所に当たった！！');
      // $this->skill でも $this->getSkill(); どちらでも可！
    } else {
      parent::attack($target);
    }
  }
}
// ミューツウ
class Player2 extends Creature
{
  private $skill;
  public function __construct($name, $hp, $img, $atMin, $atMax, $skill, $maxHp)
  {
    $this->name = $name;
    $this->hp = $hp;
    $this->img = $img;
    $this->atMin = $atMin;
    $this->atMax = $atMax;
    $this->skill = $skill;
    $this->maxHp = $maxHp;
  }
  public function getSkill()
  {
    return $this->skill;
  }
  public function getmaxHp()
  {
    return $this->maxHp;
  }
  public function attack($target)
  {
    if (!mt_rand(0, 2)) {
      History::set($this->getName() . 'のサイコキネシス🎶');
      $target->setHp($target->getHp() - $this->skill);
      History::set($this->skill . 'Pのダメージ！急所に当たった！！');
    } else {
      parent::attack($target);
    }
  }
}

// ミミッキュ
class Player3 extends Creature
{
  private $skill;
  public function __construct($name, $hp, $img, $atMin, $atMax, $skill, $maxHp)
  {
    $this->name = $name;
    $this->hp = $hp;
    $this->img = $img;
    $this->atMin = $atMin;
    $this->atMax = $atMax;
    $this->skill = $skill;
    $this->maxHp = $maxHp;
  }
  public function getSkill()
  {
    return $this->skill;
  }
  public function getmaxHp()
  {
    return $this->maxHp;
  }
  public function attack($target)
  {
      switch(mt_rand(0, 2)){
        case 0:
          History::set($this->getName() . 'のじゃれつく');
          $target->setHp($target->getHp() - $this->skill);
          History::set($this->skill . 'Pのダメージ！効果は抜群だ！！');
        break;
        case 2:
          History::set($this->getName() . 'のシャドークロー');
          $target->setHp($target->getHp() - $this->skill);
          History::set($this->skill . 'Pのダメージ！効果は抜群だ！！');
        break;
        default:
          parent::attack($target);
        break;
      }
  }
}

// モンスタークラス
class Monster extends Creature
{
  private $skill;
  public function __construct($name, $hp, $img, $atMin, $atMax, $skill, $maxHp)
  {
    $this->name = $name;
    $this->hp = $hp;
    $this->img = $img;
    $this->atMin = $atMin;
    $this->atMax = $atMax;
    $this->skill = $skill;
    $this->maxHp = $maxHp;
  }
  public function getSkill()
  {
    return $this->skill;
  }
  public function getmaxHp(){
    return $this->maxHp;
  }
  public function attack($target)
  {
    if (!mt_rand(0, 3)) {
      History::set($this->name . 'の体当たり');
      $target->setHp($target->getHp() - $this->skill);
      switch($this->skill){
        case $this->skill <= 30:
           History::set($this->skill . 'Pのダメージ！効果は今ひとつだ...');
        break;
        case $this->skill >= 31 && $this->skill  <= 99:
          History::set($this->skill . 'Pのダメージ！');
        break;
        case $this->skill >= 100:
          History::set($this->skill . 'Pのダメージ！急所に当たった！！');
      }
    } else {
      parent::attack($target);
    }
  }
}

interface HistoryInterface
{
  public static function set($str);
  public static function clear();
}
// 履歴管理クラス
class History implements HistoryInterface
{
  // セッションhistoryが作られていなければ作る
  // 文字列をセッションhistoryへ
  public static function set($str)
  {
    if (empty($_SESSION['history'])) $_SESSION['history'] = '';
    $_SESSION['history'] .= $str . '<br>';
  }
  public static function clear()
  {
    unset($_SESSION['history']);
  }
}

// インスタンス生成
$players[] = new Player('リザードン', 1000, 'https://78npc3br.user.webaccel.jp/poke/xy/n6.gif', 40, 120, mt_rand(70, 150),1000);
$players[] = new Player2('ミューツウ', 800, 'https://www2.koro-pokemon.com/img1/i_myuutuu.png', 80, 180, mt_rand(50, 200),800);
$players[] = new Player3('ミミッキュ', 900, 'https://www2.koro-pokemon.com/imgsm/s_mimikkyu.png', 10, 180, mt_rand(100, 250),900);
$monsters[] = new Monster('ゲンガー', 120, 'https://sp3.raky.net/poke/icon96/n94.gif', 20, 50, mt_rand(10, 40), 120);
$monsters[] = new Monster('カビゴン', 150, 'https://78npc3br.user.webaccel.jp/poke/icon96/n143.gif', 40, 70, mt_rand(10, 30), 150);
$monsters[] = new Monster('バンギラス', 200, 'https://www2.koro-pokemon.com/img1/i_bangirasu.png', 70, 90, mt_rand(110, 130), 200);
$monsters[] = new Monster('ヘラクロス', 80, 'https://www2.koro-pokemon.com/img1/i_herakurosu.png', 20, 90, mt_rand(10, 150), 80);
$monsters[] = new Monster('ルギア', 180, 'https://www2.koro-pokemon.com/img1/i_rugia.png', 50, 90, mt_rand(120, 150), 180);
$monsters[] = new Monster('コイキング', 100, 'https://www2.koro-pokemon.com/img1/i_koikingu.png', 20, 30, mt_rand(200, 210), 100);

  // モンスター数
function createMonster()
{
  global $monsters;
  $monster = $monsters[mt_rand(0, 5)];
  History::set($monster->getName() . 'が現れた！');
  $_SESSION['monster'] = $monster;
}

//プレイヤー数
function createPlayer()
{
  global $players;
  $player = $players[mt_rand(0,2)];
  History::set($player->getName().'が現れた！');
  $_SESSION['player'] = $player;
}

function init()
{
  History::clear();
  $_SESSION['koCt'] = 0;
  createPlayer();
  createMonster();
}
function gameOver()
{
  $_SESSION = array();
}

// 必殺技
function special($target)
{
  History::clear();
  $attackPt = mt_rand(0, 250);
  History::set($_SESSION['player']->getName() . 'のギガインパクト！');
  $target->setHp($target->getHp() - $attackPt);
  switch($attackPt){
    case $attackPt <= 30:
       History::set($attackPt . 'Pのダメージ！！効果は今ひとつだ...');
    break;
    case $attackPt >= 31 && $attackPt  <= 99:
      History::set($attackPt . 'Pのダメージ！！');
    break;
    case $attackPt >= 100:
      History::set($attackPt . 'Pのダメージ！！効果は抜群だ！！');
    break;
  }
      History::set($_SESSION['monster']->getName() . 'の攻撃！！');
      $_SESSION['monster']->attack($_SESSION['player']);
  if ($_SESSION['player']->getHp() <= 0) {
    gameOver();
  } else {
    if ($_SESSION['monster']->getHp() <= 0) {
      History::set($_SESSION['monster']->getName() . 'を倒した！！');
      $_SESSION['koCt'] = $_SESSION['koCt'] + 1;
      createMonster();
    }
  }
}

// post送信されていた場合
if (!empty($_POST)) {
  $attackFlg = (!empty($_POST['attack'])) ? true : false;
  $startFlg = (!empty($_POST['start'])) ? true : false;
  $recoverFlg = (!empty($_POST['recover'])) ? true : false;
  $specialFlg = (!empty($_POST['special'])) ? true : false;
  $escapeFlg = (!empty($_POST['escape'])) ? true : false;

  if ($startFlg) {
    History::set('ゲームスタート');
    init();
  } else {
    //攻撃
    if ($attackFlg) {
      // 攻撃のすると前の履歴が消える
      History::clear();
      History::set($_SESSION['player']->getName() . 'の攻撃！！');
      $_SESSION['player']->attack($_SESSION['monster']);
    //  モンスターが攻撃
      History::set($_SESSION['monster']->getName() . 'の攻撃！！');
      $_SESSION['monster']->attack($_SESSION['player']);

      // HPが０以下になればゲームオーバー
      if ($_SESSION['player']->getHp() <= 0) {
        gameOver();
      } else {
        // 別のモンスターを出現される
        if ($_SESSION['monster']->getHp() <= 0) {
          History::set($_SESSION['monster']->getName() . 'を倒した！！');
          $_SESSION['koCt'] = $_SESSION['koCt'] + 1;
          createMonster();
        }
      }
    } elseif ($recoverFlg) {
      History::set($_SESSION['player']->getName() . 'のHPが100回復した！');
      // 傷薬
      $_SESSION['player']->setHp($_SESSION['player']->getHp() + 100);
    } elseif ($specialFlg) {
      special($_SESSION['monster']);
      // 逃げる
    }elseif($escapeFlg){
      History::set($_SESSION['player']->getName().'が逃げた');
      // 二分の一の確率で失敗
      if(!mt_rand(0,1)){
        History::set('しかし、'.$_SESSION['monster']->getName().'に回り込まれた...');
        History::set($_SESSION['monster']->getName().'の攻撃！');
        $_SESSION['monster']->attack($_SESSION['player']);
        // HPが０以下になればゲームオーバー
        if ($_SESSION['player']->getHp() <= 0) {
        gameOver();
        // 逃走成功
      }else{
        History::set($_SESSION['player']->getName().'は無事逃げ切れた！');
        createMonster();
      }
     }
    }
  }
  $_POST = array();
}
?>
