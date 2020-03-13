<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-tooling for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-tooling/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace ZendTest\Expressive\Tooling\CreateMiddleware;

use PHPUnit\Framework\TestCase;
use Zend\Expressive\Tooling\CreateMiddleware\CreateMiddlewareException;

class CreateMiddlewareExceptionTest extends TestCase
{
    public function testMissingComposerJsonReturnsInstance()
    {
        $e = CreateMiddlewareException::missingComposerJson();
        $this->assertInstanceOf(CreateMiddlewareException::class, $e);
        $this->assertStringContainsString('Could not find a composer.json', $e->getMessage());
    }

    public function testMissingComposerAutoloadersReturnsInstance()
    {
        $e = CreateMiddlewareException::missingComposerAutoloaders();
        $this->assertInstanceOf(CreateMiddlewareException::class, $e);
        $this->assertStringContainsString('PSR-4 autoloaders', $e->getMessage());
    }

    public function testInvalidComposerJsonReturnsInstanceWithErrorMessage()
    {
        $error = 'Invalid or malformed JSON';
        $e = CreateMiddlewareException::invalidComposerJson($error);
        $this->assertInstanceOf(CreateMiddlewareException::class, $e);
        $this->assertStringContainsString('Unable to parse composer.json: ', $e->getMessage());
        $this->assertStringContainsString($error, $e->getMessage());
    }

    public function testAutoloaderNotFoundReturnsInstanceUsingClassNameProvided()
    {
        $expected = __CLASS__;
        $e = CreateMiddlewareException::autoloaderNotFound($expected);
        $this->assertInstanceOf(CreateMiddlewareException::class, $e);
        $this->assertStringContainsString('match ' . $expected, $e->getMessage());
    }

    public function testUnableToCreatePathReturnsInstanceUsingPathAndClassProvided()
    {
        $path = __FILE__;
        $class = __CLASS__;
        $e = CreateMiddlewareException::unableToCreatePath($path, $class);
        $this->assertInstanceOf(CreateMiddlewareException::class, $e);
        $this->assertStringContainsString('directory ' . $path, $e->getMessage());
        $this->assertStringContainsString('class ' . $class, $e->getMessage());
    }

    public function testClassExistsReturnsInstanceUsingPathAndClassProvided()
    {
        $path = __FILE__;
        $class = __CLASS__;
        $e = CreateMiddlewareException::classExists($path, $class);
        $this->assertInstanceOf(CreateMiddlewareException::class, $e);
        $this->assertStringContainsString('directory ' . $path, $e->getMessage());
        $this->assertStringContainsString('Class ' . $class, $e->getMessage());
    }
}
