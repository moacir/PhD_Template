<!DOCTYPE html>
<html lang="{LANG}">
  <head>
    <meta charset="utf-8">
    <title>{TITLE}</title>

    <link href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px;
      }
      .container > footer p {
        text-align: center;
      }
      .container {
        width: 820px;
      }
      .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px;
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }
      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }
      .content .span10,
      .content .span3 {
        min-height: 500px;
      }
      .content .span3 {
        margin-left: 20px;
        padding-left: 19px;
        border-left: 1px solid #eee;
      }
      .topbar .btn {
        border: 0;
      }
      code {
        border: 1px solid #ccc;
        background-color: #f5f5f5;
        display: block;
        padding: 8.5px;
        margin: 0 0 18px;
        line-height: 18px;
      }
      blockquote {
        background-color: #f9f9f9;
        padding-top: 8.5px;
        padding-bottom: 8.5px;
      }
      .refsect1 .title {
        border-bottom: 1px solid #ddd;
        margin-bottom: 10px;
      }
      .warning b.warning,
      .tip b.tip,
      .caution b.caution,
      .information b.information {
        display: block;
        text-align: center;
      }
      .warning h1, .warning h2, .warning h3, .warning h4, .warning h5, .warning h6 {
        font-size: 14px;
        line-height: 16px;
        text-align: center;
      }
    </style>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
      <script>
        $(document).ready(function () {
            $('.warning').not('b.warning').addClass('alert-message block-message');
            $('.caution').not('b.caution').addClass('alert-message block-message warning');
            $('.tip').not('b.tip').addClass('alert-message block-message info');
            $('.information').not('b.information').addClass('alert-message block-message info');
            $('table').addClass('zebra-striped');
        });
      </script>
  </head>
  <body>
    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="{HOME_HREF}">{HOME_DESC}</a>
          <div class="pull-right">
            <ul class="nav">
              <li><a accesskey="u" href="{UP_HREF}">Up</a></li>
              <li><a accesskey="p" href="{PREV_HREF}">Prev</a></li>
              <li><a accesskey="n" href="{NEXT_HREF}">Next</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="content">
        <div class="row">
          <div class="span10">
            {CONTENT}
          </div>
          <div class="span3">
            <h3>Table of Contents</h3>
            {TOC}
          </div>
        </div>
      </div>
      <footer>
        <p>Created using <a href="{PHD_URL}">PhD</a> {PHD_VERSION}</p>
      </footer>
    </div>
  </body>
</html>
