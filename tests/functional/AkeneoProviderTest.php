<?php

namespace functional\Kiboko\Component\ExpressionLanguage\Akeneo;

use Kiboko\Component\ExpressionLanguage\Akeneo\AkeneoFilterProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Vfs\FileSystem;

class AkeneoProviderTest extends TestCase
{
    private ?FileSystem $fs = null;

    protected function setUp(): void
    {
        $this->fs = FileSystem::factory('vfs://');
        $this->fs->mount();
    }

    protected function tearDown(): void
    {
        $this->fs->unmount();
        $this->fs = null;
    }

    public function dataProvider()
    {
        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR"))',
        ];

        yield [
            [],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("it_IT"))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("print"))',
        ];

        yield [
            [],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("mobile"))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("print"), locale("fr_FR"))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR", "fr_CA"))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("web", "print"))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, anyOf(scope("web"), locale("fr_FR")))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR"), coalesce("print", "web"))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR"), coalesce("web", "print"))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, slice(1, 2))',
        ];

        yield [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, head(3))',
        ];

        yield [
            [
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_US',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, tail(3))',
        ];

        yield [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, first())',
        ];

        yield [
            [
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, last())',
        ];

        yield [
            [
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, offset(1))',
        ];

        yield [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_GB',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, locale("fr_FR", "fr_CA", "en_US"))',
        ];

        yield [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_GB',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'marketplace',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_GB',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("print", "mobile", "web"))',
        ];

        yield [
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            [
                [
                    'locale' => 'en_US',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'web',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_CA',
                    'scope' => 'marketplace',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'fr_FR',
                    'scope' => 'print',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
                [
                    'locale' => 'en_GB',
                    'scope' => 'mobile',
                    'data' => 'Lorem ipsum dolor sit amet',
                ],
            ],
            'filter(input, scope("print", "mobile", "web"), first())',
        ];
    }

    /**
     * @param array $expected
     * @param array $input
     * @param string $expression
     *
     * @dataProvider dataProvider
     */
    public function testExecutingFilter(array $expected, array $input, string $expression)
    {
        $interpreter = new ExpressionLanguage(null, [new AkeneoFilterProvider()]);

        $this->assertEquals($expected, $interpreter->evaluate($expression, ['input' => $input]));
    }

    /**
     * @param array $expected
     * @param array $input
     * @param string $expression
     *
     * @dataProvider dataProvider
     */
    public function testCompiledFilter(array $expected, array $input, string $expression)
    {
        $interpreter = new ExpressionLanguage(null, [new AkeneoFilterProvider()]);

        $filename =  'vfs://' . hash('sha512', random_bytes(512)) . '.php';
        file_put_contents($filename, '<?php return function(array $input) {return ' . ($interpreter->compile($expression, ['input'])) . ';};');
        $compiled = include $filename;

        $this->assertEquals($expected, $compiled($input));
    }
}
