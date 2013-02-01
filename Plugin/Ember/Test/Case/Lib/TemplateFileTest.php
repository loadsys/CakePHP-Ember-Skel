<?php

App::uses('TemplateFile', 'Ember.Lib');

class TemplateFileTest extends CakeTestCase {
	public $template;
	public $basePath;

	public function setUp() {
		$this->basePath = APP.'Plugin'.DS.'Ember'.DS.'Test'.DS.'tmp';
		$this->template = new TemplateFile($this->basePath, 'first_dir/second_template.hbs');
	}

	public function tearDown() {
		unset($this->template);
	}

	public function testHasAbsolutePath() {
		$absPath = $this->basePath . DS . 'first_dir/second_template.hbs';
		$this->assertEqual($absPath, $this->template->absolutePath());
	}

	public function testJoinPath() {
		$expect = 'one'.DS.'two';
		$this->assertEqual($expect, $this->template->joinPath('one', 'two'));
		$this->assertEqual($expect, $this->template->joinPath('one/', 'two'));
		$this->assertEqual($expect, $this->template->joinPath('one', '/two'));
		$this->assertEqual($expect, $this->template->joinPath('one/', '/two'));
	}

	public function testTemplateName() {
		$this->assertEqual('firstDir/secondTemplate', $this->template->templateName());
	}

	public function testBuildsTemplateName() {
		$this->assertEqual('secondTemplate', $this->template->convertName('second_template'));
	}

	public function testBuildsPartialName() {
		$this->assertEqual('_firstPartial', $this->template->convertName('_first_partial'));
	}

	public function testGetsContent() {
		$this->assertEqual('Second Template', $this->template->content());
	}

	public function testGetsWrappedContent() {
		$expected = "<script type=\"text/x-handlebars\" data-template-name=\"firstDir/secondTemplate\">\nSecond Template\n</script>";
		$this->assertEqual($expected, $this->template->wrappedContent());
	}

	public function testGetsFileModificationTime() {
		$this->assertTrue(is_int($this->template->lastModified()));
	}

	public function testGetsACacheName() {
		$expected = 'firstdir_secondtemplate_' . $this->template->lastModified();
		$this->assertEqual($expected, $this->template->cacheName());
	}
}
