<?php
/*
Install
=======

## 1. Edit lib/html.php

  // in edit_form()

  $form_helper = include(DATA_HOME . SKIN_DIR . 'form_helper.php');
  ...
  // 'margin-bottom', 'float:left', and 'margin-top'
  // are for layout of 'cancel button'
  $body = <<<EOD
...
 <form action="$script" method="post" style="margin-top:0px;">
  <input type="hidden" name="cmd"    value="edit" />
  <input type="hidden" name="page"   value="$s_page" />
  <input type="submit" name="cancel" value="$_btn_cancel" accesskey="c" />
 </form>
$form_helper
EOF;

## 2. Edit plugin/secedit.inc.php if you use the plugin.

  # in function form()
  ...
  $form_helper = include(DATA_HOME . SKIN_DIR . 'form_helper.php');

  return <<<EOD
<div class="edit_form">
...
   <input type="submit" name="cancel"  value="$_btn_cancel"  accesskey="c" />
   <textarea name="original" rows="1" cols="1" style="display:none">$this->s_original</textarea>
  </div>
$form_helper
...
EOD;

## 3. Required jQuery in your skin.

Reference: https://code.jquery.com

## 4. Load application.js in your skin.

<head>
...
<script src="./skin/application.js?ver=0.1"></script>
...
</head>
*/

/*

 @text@
   This string is replaced with the content selected by coursor.

 @func:function()
   call function.

*/

function form_helper_html(array $buttons, $line_break = 15)
{
  $body = '<hr>';
  $i = 0;
  foreach ($buttons as $code => $text) {
    if (strlen($code) === 0 || strlen($text) === 0) {
      $body .= '<hr>';
      continue;
    }
    $body .= sprintf('<button class="btn btn-sm btn-default" type="button" data-text="%s">%s</button>', $code, $text);
    $i++;
    if ($line_break != 0 && ($i % $line_break === 0)) {
      $body .= '<hr>';
    }
  }
  return sprintf('<div class="quick-toolbar">%s</div>', $body);
}


// code => button text
$buttons = array(
  // main
  "@func:insert_contents()"           => "目次",
  "@func:create_list(text, '-')"      => "- a",
  "@func:create_link_list(text, '-')" => "- [[a]]",
  "@func:create_list(text, '+')"      => "+ a",
  "* @text@"                          => "h2",
  "** @text@"                         => "h3",
  "*** @text@"                        => "h4",
  "**** @text@"                       => "h5",
  "#br"                               => "#br",
  "#ref(@text@)"                      => "#ref",
  "----"                              => "水平線",
  "|~head1|~head2|h|body1|body2|"     => "|表|",
  "#comment"                          => "#comment",
  "#article"                          => "#article",
  "===== sub ====="                   => "",
  ": 定義 | 説明"                     => ":a|b",
  "''@text@''"                        => "B",
  "'''@text@'''"                      => "I",
  "%%@text@%%"                        => "取消線",
  "((@text@))"                        => "((注))",
  ">@text@"                           => "> a",
  ">>@text@"                          => ">> a",
  ">>>@text@"                         => ">>> a",
  "LEFT:@text@"                       => "LEFT:",
  "CENTER:@text@"                     => "CENTER:",
  "RIGHT:@text@"                      => "RIGHT:",
  "#clear"                            => "#clear",
  // sub
  "===== sub2 ====="  => "",
  "&size(){@text@};"  => "&size",
  "&color(){@text@};" => "&color",
  "&code(@text@);"    => "&code",
  "&ruby(){@text@};"  => "&ruby",
  "&aname(){@text@};" => "&aname",
  "&counter(@text@);" => "&counter",
  "&online;"          => "&online",
  "&t;"               => "&t",
  "&page;"            => "&page",
  "&date;"            => "&date",
  "&time;"            => "&time",
  "&now;"             => "&now",
  "&lastmod;"         => "&lastmod",
  "&br;"              => "&br;",
  "@func:line_break_in_cell(text)" => "cell(&br;)",
  "===== tag =====" => "",
  " &size(12){&color(white,dimgray){&nbsp;duplicate&nbsp;};}; " => "duplicate",
  "&size(12){&color(white,orange){&nbsp;参考&nbsp;};};" => "参考",
  "&size(12){&color(white,orange){&nbsp;関連&nbsp;};};" => "関連",
  "&size(12){&color(white,orange){&nbsp;注意&nbsp;};};" => "注意",
  "&size(12){&color(white,red){&nbsp;警告&nbsp;};};"    => "警告",
  "&size(12){&color(white,dodgerblue){&nbsp;メモ&nbsp;};};" => "メモ",
  "&size(12){&color(white,green){&nbsp;OK&nbsp;};};" => "OK",
  "&size(12){&color(white,red){&nbsp;NG&nbsp;};};" => "NG",
  "&size(12){&color(white,#00afcc){&nbsp;サンプル&nbsp;};};" => "サンプル",
  // icon
  "===== icon =====" => "",
  "&heart;"    => "&lastmod",
  "&smile;"    => "&smile",
  "&bigsmile;" => "&bigsmile",
  "&huh;"      => "&huh",
  "&oh;"       => "&oh",
  "&wink;"     => "&wink",
  "&sad;"      => "&sad",
  "&worried;"  => "&worried",
  // geshi
  "===== geshi =====" => "",
  "#geshi{{{\n@text@\n}}}"       => "#geshi()",
  "#geshi(ruby){{{\n@text@\n}}}" => "ruby",
  "#geshi(php){{{\n@text@\n}}}"  => "php",
  "#geshi(java){{{\n@text@\n}}}" => "java",
  "#geshi(javascript){{{\n@text@\n}}}" => "javascript",
  "#geshi(xml){{{\n@text@\n}}}"   => "xml",
  "#geshi(c){{{\n@text@\n}}}"     => "c",
  "#geshi(cpp){{{\n@text@\n}}}"   => "cpp",
  "#geshi(bash){{{\n@text@\n}}}"  => "Bash",
  "#geshi(sql){{{\n@text@\n}}}"   => "SQL",
  // pre, code
  "#pre{{{\n@text@\n}}}"  => "pre{}",
  "#code{{{\n@text@\n}}}" => "code{}",
  "@func:create_list(text, '// ')" => "コメント",
  "===== postgresql ====="  => "",
  // others
  " [[@text@>https://doxygen.postgresql.org/@text@_8c_source.html]] - on doxygen.postgresql.org" => "pg_doclink",
  " [[@text1@>@text2@]] - on doxygen.postgresql.org" => "pg_doclink2",
  // mathjax
  "===== mathjax ====="  => "",
  "#mathjax{{{\n@text@\n}}}" => "#mathjax",
  "&mathjax(){@text@};"    => "&mathjax",
);


return form_helper_html($buttons, 0);
