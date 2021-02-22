<?php

declare(strict_types = 1);

namespace Drupal\Tests\sparql_entity_storage\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\sparql_test\Entity\SparqlTest;
use Drupal\Tests\sparql_entity_storage\Traits\SparqlConnectionTrait;

/**
 * Tests the SPARQL entity storage entity/field API.
 *
 * @group sparql_entity_storage
 */
class EntityApiTest extends KernelTestBase {

  use SparqlConnectionTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'field',
    'filter',
    'link',
    'sparql_entity_storage',
    'sparql_multi_column_field_test',
    'sparql_test',
    'system',
    'text',
  ];

  /**
   * {@inheritdoc}
   */
  protected function bootEnvironment() {
    parent::bootEnvironment();
    $this->setUpSparql();
  }

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installConfig([
      'sparql_entity_storage',
      'sparql_test',
      'sparql_multi_column_field_test',
    ]);
  }

  public function test(): void {
    SparqlTest::create([
      'type' => 'fruit',
      'id' => 'http://example.com/apple',
      'title' => $this->randomString(),
      'link' => [
        [
          'uri' => 'http://example.com/1',
          'title' => 'Title 1',
        ],
        [
          'uri' => 'http://example.com/2',
          'title' => 'Title 2',
        ],
        [
          'uri' => 'http://example.com/3',
          'title' => 'Title 3',
        ],
      ],
    ])->save();
    $this->assertTrue(true);
  }

  public function tearDown(): void {
    $this->sparql->query("CLEAR GRAPH <http://example.com/fruit/graph/default>");
    parent::tearDown();
  }

}
