<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Mocha Tests</title>
  <?php echo $this->Html->css('mocha'); ?>
</head>
<body>
  <div id="mocha"></div>
  <?php echo $this->Handlebars->templates('js/app/Template'); ?>
  <?php echo $this->Html->script(array(
    'dist/libraries',
    'dist/spec_libs',
    'dist/spec_setup',
    'dist/application'
  )); ?>
  <script>
    mocha.setup('bdd');
    expect = chai.expect;
  </script>
  <?php echo $this->Html->script('dist/specs'); ?>
  <script>
    mocha.run();
  </script>
</body>
</html>