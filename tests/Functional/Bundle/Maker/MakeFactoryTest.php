<?php

namespace Zenstruck\Foundry\Tests\Functional\Bundle\Maker;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Tests\Fixtures\Entity\Category;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class MakeFactoryTest extends MakerTestCase
{
    /**
     * @test
     */
    public function can_create_factory(): void
    {
        $tester = new CommandTester((new Application(self::bootKernel()))->find('make:factory'));

        $this->assertFileDoesNotExist(self::tempFile('src/Factory/CategoryFactory.php'));

        $tester->execute(['entity' => Category::class]);

        $this->assertFileExists(self::tempFile('src/Factory/CategoryFactory.php'));
        $this->assertSame(<<<EOF
<?php

namespace App\\Factory;

use Zenstruck\\Foundry\\Tests\\Fixtures\\Entity\\Category;
use Zenstruck\\Foundry\\ModelFactory;
use Zenstruck\\Foundry\\Proxy;

/**
 * @method static Category|Proxy createOne(array \$attributes = [])
 * @method static Category[]|Proxy[] createMany(int \$number, \$attributes = [])
 * @method static Category|Proxy find(\$criteria)
 * @method static Category|Proxy findOrCreate(array \$attributes)
 * @method static Category|Proxy first(string \$sortedField = 'id')
 * @method static Category|Proxy last(string \$sortedField = 'id')
 * @method static Category|Proxy random(array \$attributes = [])
 * @method static Category|Proxy randomOrCreate(array \$attributes = [])
 * @method static Category[]|Proxy[] all()
 * @method static Category[]|Proxy[] findBy(array \$attributes)
 * @method static Category[]|Proxy[] randomSet(int \$number, array \$attributes = [])
 * @method static Category[]|Proxy[] randomRange(int \$min, int \$max, array \$attributes = [])
 * @method Category|Proxy create(\$attributes = [])
 */
final class CategoryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return \$this
            // ->afterInstantiate(function(Category \$category) {})
        ;
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}

EOF
            , \file_get_contents(self::tempFile('src/Factory/CategoryFactory.php'))
        );
    }

    /**
     * @test
     */
    public function can_create_factory_interactively(): void
    {
        $tester = new CommandTester((new Application(self::bootKernel()))->find('make:factory'));

        $this->assertFileDoesNotExist(self::tempFile('src/Factory/CategoryFactory.php'));

        $tester->setInputs([Category::class]);
        $tester->execute([]);
        $output = $tester->getDisplay();

        $this->assertFileExists(self::tempFile('src/Factory/CategoryFactory.php'));
        $this->assertStringContainsString('Note: pass --test if you want to generate factories in your tests/ directory', $output);
        $this->assertSame(<<<EOF
<?php

namespace App\\Factory;

use Zenstruck\\Foundry\\Tests\\Fixtures\\Entity\\Category;
use Zenstruck\\Foundry\\ModelFactory;
use Zenstruck\\Foundry\\Proxy;

/**
 * @method static Category|Proxy createOne(array \$attributes = [])
 * @method static Category[]|Proxy[] createMany(int \$number, \$attributes = [])
 * @method static Category|Proxy find(\$criteria)
 * @method static Category|Proxy findOrCreate(array \$attributes)
 * @method static Category|Proxy first(string \$sortedField = 'id')
 * @method static Category|Proxy last(string \$sortedField = 'id')
 * @method static Category|Proxy random(array \$attributes = [])
 * @method static Category|Proxy randomOrCreate(array \$attributes = [])
 * @method static Category[]|Proxy[] all()
 * @method static Category[]|Proxy[] findBy(array \$attributes)
 * @method static Category[]|Proxy[] randomSet(int \$number, array \$attributes = [])
 * @method static Category[]|Proxy[] randomRange(int \$min, int \$max, array \$attributes = [])
 * @method Category|Proxy create(\$attributes = [])
 */
final class CategoryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return \$this
            // ->afterInstantiate(function(Category \$category) {})
        ;
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}

EOF
            , \file_get_contents(self::tempFile('src/Factory/CategoryFactory.php'))
        );
    }

    /**
     * @test
     */
    public function can_create_factory_in_test_dir(): void
    {
        $tester = new CommandTester((new Application(self::bootKernel()))->find('make:factory'));

        $this->assertFileDoesNotExist(self::tempFile('tests/Factory/CategoryFactory.php'));

        $tester->execute(['entity' => Category::class, '--test' => true]);

        $this->assertFileExists(self::tempFile('tests/Factory/CategoryFactory.php'));
        $this->assertSame(<<<EOF
<?php

namespace App\\Tests\\Factory;

use Zenstruck\\Foundry\\Tests\\Fixtures\\Entity\\Category;
use Zenstruck\\Foundry\\ModelFactory;
use Zenstruck\\Foundry\\Proxy;

/**
 * @method static Category|Proxy createOne(array \$attributes = [])
 * @method static Category[]|Proxy[] createMany(int \$number, \$attributes = [])
 * @method static Category|Proxy find(\$criteria)
 * @method static Category|Proxy findOrCreate(array \$attributes)
 * @method static Category|Proxy first(string \$sortedField = 'id')
 * @method static Category|Proxy last(string \$sortedField = 'id')
 * @method static Category|Proxy random(array \$attributes = [])
 * @method static Category|Proxy randomOrCreate(array \$attributes = [])
 * @method static Category[]|Proxy[] all()
 * @method static Category[]|Proxy[] findBy(array \$attributes)
 * @method static Category[]|Proxy[] randomSet(int \$number, array \$attributes = [])
 * @method static Category[]|Proxy[] randomRange(int \$min, int \$max, array \$attributes = [])
 * @method Category|Proxy create(\$attributes = [])
 */
final class CategoryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return \$this
            // ->afterInstantiate(function(Category \$category) {})
        ;
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}

EOF
            , \file_get_contents(self::tempFile('tests/Factory/CategoryFactory.php'))
        );
    }

    /**
     * @test
     */
    public function can_create_factory_in_test_dir_interactively(): void
    {
        $tester = new CommandTester((new Application(self::bootKernel()))->find('make:factory'));

        $this->assertFileDoesNotExist(self::tempFile('tests/Factory/CategoryFactory.php'));

        $tester->setInputs([Category::class]);
        $tester->execute(['--test' => true]);
        $output = $tester->getDisplay();

        $this->assertFileExists(self::tempFile('tests/Factory/CategoryFactory.php'));
        $this->assertStringNotContainsString('Note: pass --test if you want to generate factories in your tests/ directory', $output);
        $this->assertSame(<<<EOF
<?php

namespace App\\Tests\\Factory;

use Zenstruck\\Foundry\\Tests\\Fixtures\\Entity\\Category;
use Zenstruck\\Foundry\\ModelFactory;
use Zenstruck\\Foundry\\Proxy;

/**
 * @method static Category|Proxy createOne(array \$attributes = [])
 * @method static Category[]|Proxy[] createMany(int \$number, \$attributes = [])
 * @method static Category|Proxy find(\$criteria)
 * @method static Category|Proxy findOrCreate(array \$attributes)
 * @method static Category|Proxy first(string \$sortedField = 'id')
 * @method static Category|Proxy last(string \$sortedField = 'id')
 * @method static Category|Proxy random(array \$attributes = [])
 * @method static Category|Proxy randomOrCreate(array \$attributes = [])
 * @method static Category[]|Proxy[] all()
 * @method static Category[]|Proxy[] findBy(array \$attributes)
 * @method static Category[]|Proxy[] randomSet(int \$number, array \$attributes = [])
 * @method static Category[]|Proxy[] randomRange(int \$min, int \$max, array \$attributes = [])
 * @method Category|Proxy create(\$attributes = [])
 */
final class CategoryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return \$this
            // ->afterInstantiate(function(Category \$category) {})
        ;
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}

EOF
            , \file_get_contents(self::tempFile('tests/Factory/CategoryFactory.php'))
        );
    }

    /**
     * @test
     */
    public function invalid_entity_throws_exception(): void
    {
        $tester = new CommandTester((new Application(self::bootKernel()))->find('make:factory'));

        $this->assertFileDoesNotExist(self::tempFile('src/Factory/InvalidFactory.php'));

        try {
            $tester->execute(['entity' => 'Invalid']);
        } catch (RuntimeCommandException $e) {
            $this->assertSame('Entity "Invalid" not found.', $e->getMessage());
            $this->assertFileDoesNotExist(self::tempFile('src/Factory/InvalidFactory.php'));

            return;
        }

        $this->fail('Exception not thrown.');
    }
}
