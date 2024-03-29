<?php

// ====================================
// ログイン認証・自動ログアウト
// ====================================
// ログインしている場合
if(!empty($_SESSION['login_date'])){
  debug('ログイン済ユーザーです');

  // 現在日時が最終ログイン日時+有効期限を超えていた場合
  if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()){
    debug('ログイン有効期限オーバーです');

    // セッションを削除(ログアウトする)
    session_destroy();
    // ログインページへ
    header("Location:./login.php");
  }else{
    debug('ログイン有効期限以内です');
    // 最終ログイン日時を現在日時に更新
    $_SESSION['login_date'] = time();

    // 現在実行中のスクリプトファイルがlogin.phpの場合
    // posted-list.phpに遷移
    if(basename($_SERVER['PHP_SELF']) === 'login.php'){
      debug('login.phpを離脱します');
      header("Location:./posted-list.php");
    }
  }
}else{
  // 実行中のスクリプトファイルがlogin.phpでない場合
  // login.phpに遷移
  debug('未ログインユーザーです');
  if(basename($_SERVER['PHP_SELF']) !== 'login.php'){
    header("Location:./login.php");
  }
}