<?php

App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('HandlebarsHelper', 'Ember.View/Helper');

class TestController extends Controller {
	public $name = 'Test';
	public $uses = null;
}

class TestHandlebarsHelper extends HandlebarsHelper {
	public function buildPaths($path) {
		return parent::_buildPaths($path);
	}
}

class HandlebarsHelperTest extends CakeTestCase {

	public $Handlebars;
	public $View;

	public function setUp() {
		parent::setUp();
		$this->basePath = APP.'Plugin'.DS.'Ember'.DS.'Test';
		$this->View = $this->getMock('View', array('append'), array(new TestController()));
		$settings = array('cache' => false, 'basePath' => $this->basePath);
		$this->Handlebars = new TestHandlebarsHelper($this->View, $settings);
		Configure::write('Asset.timestamp', false);
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->Handlebars, $this->View);
	}

	/**
	 * @expectedException InvalidSettingException
	 */
	public function testThrowsExceptionsWhenExtSettingIsIncorrect() {
		$ext = $this->Handlebars->ext;
		$this->Handlebars->ext = null;
		$this->Handlebars->templates('tmp');
		$this->Handlebars->ext = $ext;
	}

	public function testFindsAllFilesForTheDefaultExt() {
		$this->assertEqual(3, count($this->Handlebars->buildPaths('tmp')));
	}

	public function testFindsAllFilesForAStringExt() {
		$ext = $this->Handlebars->ext;
		$this->Handlebars->ext = 'hbs';
		$this->assertEqual(1, count($this->Handlebars->buildPaths('tmp')));
		$this->Handlebars->ext = $ext;
	}

	public function testAllFilesWhenExtIsArray() {
		$ext = $this->Handlebars->ext;
		$this->Handlebars->ext = array('hbs', 'handlebars', 'js');
		$this->assertEqual(4, count($this->Handlebars->buildPaths('tmp')));
		$this->Handlebars->ext = $ext;
	}

	public function testRendersAllTheTemplatesWrappedInScriptTags() {
		$this->Handlebars->compile = false;
		$expected = '<script type="text/x-handlebars" data-template-name="firstDir/_firstPartial">
First Partial
</script>
<script type="text/x-handlebars" data-template-name="firstDir/secondTemplate">
Second Template
</script>
<script type="text/x-handlebars" data-template-name="firstTemplate">
First Template
</script>';
		$this->assertEqual($expected, $this->Handlebars->templates('tmp'));
		$this->Handlebars->compile = true;
	}

	public function testRendersAllTheTemplatesCompiledInOneScriptTag() {
		$expected = "<script>Ember.TEMPLATES[\"firstDir/_firstPartial\"] = Ember.Handlebars.compile(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};



  data.buffer.push(\"First Partial\");

});
Ember.TEMPLATES[\"firstDir/secondTemplate\"] = Ember.Handlebars.compile(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};



  data.buffer.push(\"Second Template\");

});
Ember.TEMPLATES[\"firstTemplate\"] = Ember.Handlebars.compile(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [2,'>= 1.0.0-rc.3'];
helpers = helpers || Ember.Handlebars.helpers; data = data || {};



  data.buffer.push(\"First Template\");

});</script>";
		$this->assertEqual($expected, $this->Handlebars->templates('tmp'));
	}
}
