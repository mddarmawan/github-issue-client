<?php require "autoload.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title><?= env('APP_NAME') ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="assets/css/normalize.css">
  <link rel="stylesheet" href="assets/css/skeleton.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="assets/images/favicon.png">

  <style type="text/css">
    .label {
      margin-right: 5px;
      padding: 0 15px;
      height: 20px;
      line-height: 20px;
      color: #fff;
    }

    .danger {
      background-color: #ee0701 !important;
      border-color: #ee0701 !important;
    }

    .warning {
      background-color: #fbca04 !important;
      border-color: #fbca04 !important;
    }

    .success {
      background-color: #2fa009 !important;
      border-color: #2fa009 !important;
    }

    .blue {
      background-color: #84b6eb !important;
      border-color: #84b6eb !important;
    }

    .sky-blue {
      background-color: #77e5cd !important;
      border-color: #77e5cd !important;
    }

    div.scrollable {
      overflow: auto;
      padding-right: 1px;
      height: 60vh; 
      margin-bottom: 50px;
    }
  </style>

</head>
<body>
  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="six columns" style="margin-top: 18%">
        <h4><?= env('APP_NAME') ?></h4>
        <p><?= env('APP_DESCRIPTION') ?></p>
        <form id="form" method="post" action="request/create.php">
          <div class="row">
            <div class="eight columns">
              <label for="title">Title</label>
              <input name="title" class="u-full-width" type="text" placeholder="Can't open the about section" id="title" autofocus="" required="">
            </div>

            <div class="four columns">
              <label for="type">Type</label>
              <select name="type" class="u-full-width" id="type" required="">
                <option value="">...</option>
                <option value="bug">Bug</option>
                <option value="enhancement">Enhancement</option>
                <option value="help wanted">Question</option>
              </select>
            </div>
          </div>

          <label for="body-1">What happened?</label>
          <textarea name="body[]" class="u-full-width" placeholder="I can't acces the about section." id="body-1" required=""></textarea>

          <label for="body-2">How is the flow?</label>
          <textarea name="body[]" class="u-full-width" placeholder="Home > Navigation > About" id="body-2" required=""></textarea>

          <label for="body-3">What to expect?</label>
          <textarea name="body[]" class="u-full-width" placeholder="The about section can be opened." id="body-3" required=""></textarea>

          <input class="button-primary" type="submit" value="Submit">
        </form>
      </div>

      <div class="six columns" style="margin-top: 18%">
        <center><h5>Issues</h5></center>
        <div class="scrollable" id="issuesContainer">
        </div>
      </div>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <script type="text/javascript">
    function setForm() {
      $('#form').submit(function(e) {
        e.preventDefault();
        postIssue();
      });
    }

    function getIssues() {
      $.get('http://127.0.0.1:8000/request/read.php', function(response) {
        response = JSON.parse(response);

        if (response.status == 'success') {
          $.each(response.data, function(index, item) {
            setIssue(item);
          });
        }
      });
    }

    function postIssue() {
      $('input[type=submit]').val('Submitting...');
      $.post('http://127.0.0.1:8000/request/create.php', $('#form').serialize())
        .done(function(response) {
          response = JSON.parse(response);

          if (response.status == 'success') {
            $.each(response.data, function(index, item) {
              setIssue(item, true);
            });
            $('input[type=submit]').val('Submit');
            $('#form').find("input[type=text], textarea, select").val("");
          } else {
            alert(response.message);
          }
        });
    }

    function setIssue(issue, update = false) {
      var body = '';
      var labels = '';
      var $ELEMENT = $('#issuesContainer');

      if (issue.body) {
        body = `<p>${marked(issue.body)}</p>`;
      }

      if (issue.state == 'closed') {
        labels += '<span class="button button-primary label success">Closed</span>';
      }

      if (issue.labels) {
        $.each(issue.labels, function(index, item) {
          switch (item.name) {
            case 'bug':
              labels += '<span class="button button-primary label danger">Bug</span>';

              break;

            case 'in progress':
              if (issue.state == 'open') {
                labels += '<span class="button button-primary label warning">In Progress</span>';
              }

              break;

            case 'enhancement':
              labels += '<span class="button button-primary label blue">Enhancement</span>';

              break;

            case 'help wanted':
                labels += '<span class="button button-primary label sky-blue">Help Wanted</span>';

              break;
          }
        });
      }

      if (update) {
        $ELEMENT.prepend(`
          <div>
            <h6><b>${issue.title}</b> <span>#${issue.number}</span></h6>
            ${body}
            ${labels}
            <hr>
          </div>
        `);
      } else {
        $ELEMENT.append(`
          <div>
            <h6><b>${issue.title}</b> <span>#${issue.number}</span></h6>
            ${body}
            ${labels}
            <hr>
          </div>
        `);
      }

    }

    $(document).ready(function() {
      getIssues();
      setForm();
    });
  </script>
</body>
</html>
