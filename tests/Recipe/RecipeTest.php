<?php

namespace Drupal\simplerecipe\tests\Recipe;

use PHPUnit_Framework_TestCase;
use Drupal\simplerecipe\Recipe\Exception as RecipeException;
use Drupal\simplerecipe\Recipe\Recipe;
use Drupal\simplerecipe\Stub;
use Drupal\simplerecipe\tests\TestDoubles\Stub as TestStub;
use Drupal\simplerecipe\Connector\Connector;

require_once dirname(__FILE__) . '/../../autoload.php';
require_once dirname(__FILE__) . '/../autoload.php';

class RecipeTest extends PHPUnit_Framework_TestCase {

  public function setUp() {
    TestStub::initStub();
  }

  public function testSetTitle() {
    $recipe = new Recipe();

    $recipe->setTitle('Some title');
    $this->assertEquals('Some title', $recipe->title);
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetLongTitle() {
    $recipe = new Recipe();

    $recipe->setTitle(str_pad('', 256, 'b'));
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetShortTitle() {
    $recipe = new Recipe();

    $recipe->setTitle('');
  }

  public function testSetAuthor() {
    $recipe = new Recipe();

    $recipe->setAuthorName('Some author');
    $this->assertEquals('Some author', $recipe->author_name);
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetLongAuthor() {
    $recipe = new Recipe();

    $recipe->setAuthorName(str_pad('', 256, 'b'));
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetShortAuthor() {
    $recipe = new Recipe();

    $recipe->setAuthorName('');
  }

  public function testSetMail() {
    $recipe = new Recipe();

    $recipe->setAuthorMail('Some mail');
    $this->assertEquals('Some mail', $recipe->author_mail);
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetLongMail() {
    $recipe = new Recipe();

    $recipe->setAuthorMail(str_pad('', 256, 'b'));
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetShortMail() {
    $recipe = new Recipe();

    $recipe->setAuthorMail('');
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetInvalidMail() {
    $stub = $this->getMockBuilder('Drupal\simplerecipe\tests\TestDoubles\Stub')->getMock();
    $stub->method('valid_email_address')->willReturn(FALSE);
    Stub::attach($stub);

    $recipe = new Recipe();

    $recipe->setAuthorMail('erwitema@gmail.com');
  }

  public function testSetDescription() {
    $recipe = new Recipe();

    $recipe->setRecipeDescription("Some description");
    $this->assertEquals("Some description", $recipe->recipe_description);
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetLongDescription() {
    $recipe = new Recipe();

    $recipe->setRecipeDescription(str_pad('', 501, 'b'));
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetShortDescription() {
    $recipe = new Recipe();

    $recipe->setRecipeDescription('');
  }

  public function testSetInstructionsIngredients() {
    $recipe = new Recipe();

    $recipe->setRecipeInstructions("Some instructions");
    $this->assertEquals("Some instructions", $recipe->recipe_instructions);

    $recipe->setRecipeIngredients("Some ingredients");
    $this->assertEquals("Some ingredients", $recipe->recipe_ingredients);
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetInvalidId() {
    $recipe = new Recipe();

    $recipe->setId('abc');
  }

  public function testSetId() {
    $recipe = new Recipe();

    $recipe->setId('1');
    $this->assertEquals(1, $recipe->id);
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetEmptyLanguage() {
    $recipe = new Recipe();

    $recipe->setLangcode('');
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetOnedigitLanguage() {
    $recipe = new Recipe();

    $recipe->setLangcode('s');
  }

  public function testSetTwoLangcode() {
    $recipe = new Recipe();

    $recipe->setLangcode('ss');
    $this->assertEquals('ss', $recipe->langcode);
  }

  /**
   * @expectedException Drupal\simplerecipe\Recipe\Exception
   */
  public function testSetThreedigitLanguage() {
    $recipe = new Recipe();

    $recipe->setLangcode('sss');
  }

  public function testLoad() {
    $conn = $this->getMockBuilder('Drupal\simplerecipe\Connector\Connector')->getMock();
    $conn->method('load')->willReturn(array(array('id' => 1)));
    $conn->expects($this->once())->method('load');
    Connector::attach($conn);

    $recipe = Recipe::load(1);
    $this->assertEquals(1, $recipe->id);
  }

  public function testInsert() {
    $conn = $this->getMockBuilder('Drupal\simplerecipe\Connector\Connector')->getMock();
    $conn->method('insert')->willReturn(1);
    $conn->expects($this->once())->method('insert');
    Connector::attach($conn);

    $recipe = new Recipe();
    $recipe->insert();

    $this->assertNotNull($recipe->id);
    $this->assertNotNull($recipe->created);
  }

}
