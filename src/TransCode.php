<?php
// +----------------------------------------------------------------------
// | 调用Natron软件进行转码
// +----------------------------------------------------------------------
namespace Natron;

class TransCode
{
    // python 脚本保存位置


    /**
     * transCode constructor.
     */
    public function __construct()
    {

    }

    /**
     * 需要传入python 脚本保存地址 和 Natron 默认安装位置
     */
    public function init()
    {

    }

    public function run($param)
    {
        $generatePythonScript = new  GeneratePythonScript();
        $template = $generatePythonScript->generate($param);
        $this->fillToFile($template);
    }

    public function fillToFile($content)
    {
        $file = fopen("test_write_py.py", "w") or die("Unable to open file!");
        fwrite($file, $content);
        fclose($file);
    }
}


