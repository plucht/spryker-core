<?php

namespace Unit\SprykerFeature\Zed\Development\Business\CodeStyleFixer\Fixtures\SprykerUseStatementFixer\Input;

use SprykerEngine\Zed\Foo;
use Pyz\Zed\Foo\Bar\Baz;
use X\Y;
use SprykerFeature\Zed\Maintenance\Business\InstalledPackages\InstalledPackageFinder as InstalledPackagesInstalledPackageFinder;
use Foo\InstalledPackageFinder;

class TestClass1Input extends \Pyz\Zed\Foo\Bar\Baz
{

    public function replaceFunction()
    {
        new Foo($x);
        new Baz($x);
    }

    public function replaceFunctionB()
    {
        new Foo($x);
    }

    protected function replaceFunctionC(\Foo\PackagesTransfer $collection, $path)
    {
        $x = new InstalledPackageFinder();
        $y = new InstalledPackagesInstalledPackageFinder();

        return new InstalledPackagesInstalledPackageFinder(
            $collection,
            $path
        );
    }

    public function replaceNotYetFunction()
    {
        //TODO: Baz::x();
        \Pyz\Zed\Foo\Bar\Baz::x();
    }

    public function doNotReplaceFunction()
    {
        return new \DateTime\Foo();
    }

}