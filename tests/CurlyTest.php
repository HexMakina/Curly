<?php
declare(strict_types=1);

namespace HexMakina\Curly\tests;

use PHPUnit\Framework\TestCase;
use HexMakina\Curly\Curly;

final class CurlyTest extends TestCase
{
  /**
   * @var string[]
   */
    private array $urls = [];


    protected function setUp(): void
    {
        $this->urls = [
          'wellformed' => 'https://liebrex.net',
          'minimalist' => 'liebrex.net'
        ];
    }

    public function testEmptyConstructor(): void
    {
        $this->expectException(\ArgumentCountError::class);
        /** @scrutinizer ignore-call */
        new Curly();
    }

    public function testNoOptionsConstructor(): void
    {
        foreach($this->urls as $url){
          $c = new Curly($url);
        }
    }
  //
  //   public function testStaticCall(): void
  //   {
  //       foreach ($this->tags as $tag) {
  //           $e = new Element($tag);
  //           $e_static = Element::$tag();
  //           $this->assertEquals("$e", "$e_static");
  //       }
  //   }
  //
  //   public function testIsVoid(): void
  //   {
  //       foreach ($this->tags as $tag) {
  //           $e = new Element($tag);
  //           $this->assertEquals($e->isVoid(), in_array($tag, Element::VOID_ELEMENTS));
  //       }
  //   }
  //
  //   public function testCreateEmptyElement(): void
  //   {
  //       foreach ($this->tags as $tag) {
  //           $e = new Element($tag);
  //           if ($e->isVoid()) {
  //               $this->assertEquals('<' . $tag . '/>', $e->__toString());
  //           } else {
  //               $this->assertEquals(sprintf('<%s></%s>', $tag, $tag), $e->__toString());
  //           }
  //       }
  //   }
  //
  //   public function testCreateElementWithContent(): void
  //   {
  //       $messages = [
  //       'lorem ipsum' => 'lorem ipsum',
  //       '' => '',
  //       null => ''
  //       ];
  //
  //       foreach ($messages as $message => $expected) {
  //           foreach ($this->tags as $tag) {
  //               $e = new Element($tag, $message);
  //
  //               if ($e->isVoid()) {
  //                   $this->assertEquals('<' . $tag . '/>', $e->__toString());
  //               } else {
  //                   $this->assertEquals(sprintf('<%s>%s</%s>', $tag, $expected, $tag), $e->__toString());
  //               }
  //           }
  //       }
  //   }
  //
  // // Attributes
  //   public function testCreateElementWithAttributes(): void
  //   {
  //       $message = 'lorem ipsum';
  //       $attributes = ['id' => 'test_id'];
  //       $attributes_expected_string = ' id="test_id"';
  //
  //     // testing attributes string generator
  //       $this->assertEquals(Element::attributesAsString($attributes), $attributes_expected_string);
  //
  //     // testing all HTML tags
  //       $this->assertForAllHTMLTags($message, $attributes, $attributes_expected_string);
  //   }
  //
  //   public function testCreateElementWithBooleanAttributes(): void
  //   {
  //       $message = 'lorem ipsum';
  //       $attributes = ['id' => 'test_id', 'checked', 'class' => 'test_class', 'required'];
  //       $attributes_expected_string = ' id="test_id" checked class="test_class" required';
  //
  //     // testing attributes string generator
  //       $this->assertEquals(Element::attributesAsString($attributes), $attributes_expected_string);
  //
  //     // testing all HTML tags
  //       $this->assertForAllHTMLTags($message, $attributes, $attributes_expected_string);
  //   }
  //
  //   public function testAttributesOrdering(): void
  //   {
  //       $message = 'lorem ipsum';
  //
  //       $attributes = ['id' => 'test_id', 'class' => 'test_class', 'style="color:red;"'];
  //       $attributes_expected_string = ' id="test_id" class="test_class" style="color:red;"';
  //
  //     // testing attributes string generator
  //       $this->assertEquals(Element::attributesAsString($attributes), $attributes_expected_string);
  //
  //     // testing all HTML tags
  //       $this->assertForAllHTMLTags($message, $attributes, $attributes_expected_string);
  //
  //
  //       $attributes = ['class' => 'test_class', 'style="color:red;"','id' => 'test_id'];
  //       $attributes_expected_string = ' class="test_class" style="color:red;" id="test_id"';
  //
  //     // testing attributes string generator
  //       $this->assertEquals(Element::attributesAsString($attributes), $attributes_expected_string);
  //
  //     // testing all HTML tags
  //       $this->assertForAllHTMLTags($message, $attributes, $attributes_expected_string);
  //   }
  //
  //
  // /**
  //  * @param mixed[] $attributes
  //  */
  //   private function assertForAllHTMLTags(string $message, array $attributes, string $attributes_expected_string): void
  //   {
  //       foreach ($this->tags as $tag) {
  //         // testing by instantiation
  //           $e = new Element($tag, $message, $attributes);
  //           if (in_array($tag, Element::VOID_ELEMENTS)) {
  //               $this->assertEquals(sprintf(Element::FORMAT_VOID, $tag, $attributes_expected_string), $e->__toString());
  //           } else {
  //               $this->assertEquals(sprintf(Element::FORMAT_ELEMENT, $tag, $attributes_expected_string, $message, $tag), $e->__toString());
  //           }
  //       }
  //   }
}
