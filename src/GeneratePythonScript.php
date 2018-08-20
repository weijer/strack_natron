<?php
// +----------------------------------------------------------------------
// | 组装 Natron 转码Python脚本文件
// +----------------------------------------------------------------------
namespace Natron;

class GeneratePythonScript
{
    // Python脚本字符串
    protected $pythonScript = '';

    // 错误信息
    protected $errorMsg = '';

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        return $this->errorMsg;
    }

    /**
     * 判断参数是否正确
     * @param $param
     * @param $keys
     * @return bool
     */
    protected function checkParam($param, $keys)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $param)) {
                $this->errorMsg = 'parameter is incorrect';
                return false;
                break;
            }
        }
        return true;
    }

    /**
     * 创建读取文件节点
     * @param $nodeName
     * @param $readFilePath
     */
    protected function createReadNode($nodeName, $readFilePath)
    {
        $this->pythonScript .= "{$nodeName} = app.createReader('{$readFilePath}')" . PHP_EOL;
        $this->pythonScript .= "{$nodeName}.setScriptName('Reader{$nodeName}')" . PHP_EOL;
    }

    /**
     * 创建写出文件节点
     * @param $nodeName
     * @param $writeFilePath
     */
    protected function createWriteNode($nodeName, $writeFilePath)
    {
        $this->pythonScript .= "{$nodeName} = app.createWriter('{$writeFilePath}')" . PHP_EOL;
        $this->pythonScript .= "{$nodeName}.setScriptName('Writer{$nodeName}')" . PHP_EOL;
    }

    /**
     * 设置，确定哪个矩形的像素将被写入输出
     * 0、Input Format (input): Renders the pixels included in the input format
     * 1、Project Format (project): Renders the pixels included in the project format
     * 2、Fixed Format (fixed): Renders the pixels included in the format indicated by the Format parameter.
     * @param $nodeName
     * @param $format
     */
    protected function setFormatType($nodeName, $format)
    {
        switch ($format) {
            default:
            case "input":
                $formatNumber = 0;
                break;
            case "project":
                $formatNumber = 1;
                break;
            case "fixed":
                $formatNumber = 2;
                break;
        }
        $this->pythonScript .= "{$nodeName}.getParam('formatType').setValue({$formatNumber})" . PHP_EOL;
    }

    /**
     * 获取色彩空间Index序号
     * @param $colorSpaceName
     * @return int
     */
    protected function getColorSpaceNumber($colorSpaceName)
    {
        switch ($colorSpaceName) {
            case "linear":
                // linear/Linear: Rec. 709 (Full Range), Blender native linear space (reference, scene_linear)
                $colorSpaceNumber = 0;
                break;
            case "raw":
                // (color_picking, texture_paint)
                $colorSpaceNumber = 1;
                break;
            case "adx10":
                // Film Scan, using the 10-bit Academy Density Encoding
                $colorSpaceNumber = 2;
                break;
            case "linear_ACES":
                // ACES linear space
                $colorSpaceNumber = 3;
                break;
            case "rrt_srgb":
                // rrt srgb
                $colorSpaceNumber = 4;
                break;
            case "nuke_rec709":
                // Rec. 709 (Full Range) Display Space
                $colorSpaceNumber = 5;
                break;
            case "rrt_rec709":
                // rrt rec709
                $colorSpaceNumber = 6;
                break;
            case "rrt_p3dci":
                // rrt p3dci
                $colorSpaceNumber = 7;
                break;
            case "linear_xyz":
                // rrt srgb
                $colorSpaceNumber = 8;
                break;
            case "rrt_xyz":
                // rrt xyz
                $colorSpaceNumber = 9;
                break;
            case "dci_xyz":
                // OpenDCP output LUT with DCI reference white and Gamma 2.6
                $colorSpaceNumber = 10;
                break;
            case "lg10":
                // conversion from film log (color_timing)
                $colorSpaceNumber = 11;
                break;
            case "lgf":
                // lgf : conversion from film log (compositing_log)
                $colorSpaceNumber = 12;
                break;
            case "srgb8":
                // RGB display space for the sRGB standard.
                $colorSpaceNumber = 13;
                break;
            case "srgb":
                // （默认值）Standard RGB Display Space
                $colorSpaceNumber = 14;
                break;
            case "VD16":
                // The simple video conversion from a gamma 2.2 sRGB space
                $colorSpaceNumber = 15;
                break;
            case "cineon":
                // Cineon (Log Film Scan)
                $colorSpaceNumber = 16;
                break;
            case "panalog":
                // Sony/Panavision Genesis Log Space
                $colorSpaceNumber = 17;
                break;
            case "REDLog":
                // RED Log Space
                $colorSpaceNumber = 18;
                break;
            case "ViperLog":
                // Viper Log Space
                $colorSpaceNumber = 19;
                break;
            case "AlexaV3LogC":
                // Alexa Log C
                $colorSpaceNumber = 20;
                break;
            case "PLogLin":
                // Josh Pines style pivoted log/lin conversion. 445->0.18
                $colorSpaceNumber = 21;
                break;
            case "SLog":
                // Sony SLog
                $colorSpaceNumber = 22;
                break;
            case "SLog1":
                // Sony SLog1
                $colorSpaceNumber = 23;
                break;
            case "SLog2":
                // Sony SLog2
                $colorSpaceNumber = 24;
                break;
            case "SLog3":
                // Sony SLog3
                $colorSpaceNumber = 25;
                break;
            case "CLog":
                // Canon CLog
                $colorSpaceNumber = 26;
                break;
            case "V-Log":
                // Panasonic V-Log
                $colorSpaceNumber = 27;
                break;
            case "V-Log-V-Gamut":
                // Panasonic V-Log with V-Gamut
                $colorSpaceNumber = 28;
                break;
            case "Protune":
                // GoPro Protune
                $colorSpaceNumber = 28;
                break;
            case "Non-Color":
                // Color space used for images which contains non-color data (i,e, normal maps) (data)
                $colorSpaceNumber = 29;
                break;
            case "p3dci8":
                // p3dci8 :rgb display space for gamma 2.6 P3 projection.
                $colorSpaceNumber = 30;
                break;
            case "Filmic-Log":
                // Log based filmic shaper with 16.5 stops of latitude, and 25 stops of dynamic range.
                $colorSpaceNumber = 31;
                break;
            case "Filmic-sRGB":
                // Filmic sRGB view transform
                $colorSpaceNumber = 32;
                break;
            case "False-Color":
                //  Filmic false color view transform
                $colorSpaceNumber = 33;
                break;
        }

        return $colorSpaceNumber;
    }

    /**
     * 设置导入文件的色彩空间
     * @param $nodeName
     * @param $colorSpace
     */
    protected function setInputColorSpace($nodeName, $colorSpace)
    {
        $this->pythonScript .= "{$nodeName}.getParam('ocioOutputSpaceIndex').setValue({$this->getColorSpaceNumber($colorSpace)})" . PHP_EOL;
    }

    /**
     * 设置导出文件的色彩空间
     * @param $nodeName
     * @param $colorSpace
     */
    protected function setOutputColorSpace($nodeName, $colorSpace)
    {
        $this->pythonScript .= "{$nodeName}.getParam('ocioOutputSpaceIndex').setValue({$this->getColorSpaceNumber($colorSpace)})" . PHP_EOL;
    }

    /**
     * 设置视频格式（默认为6：MP4）
     * @param $nodeName
     * @param int $format
     */
    protected function setVideoFormat($nodeName, $format = 6)
    {
        $this->pythonScript .= "{$nodeName}.getParam('format').setValue({$format})" . PHP_EOL;
    }

    /**
     * 设置视频编码（默认为37 H264 libx264rgb）
     * @param $nodeName
     * @param int $codec
     */
    protected function setVideoCodec($nodeName, $codec = 37)
    {
        $this->pythonScript .= "{$nodeName}.getParam('codec').setValue({$codec})" . PHP_EOL;
    }

    /**
     * 设置视频帧速率
     * @param $nodeName
     * @param int $fps
     */
    protected function setVideoFPS($nodeName, $fps = 24)
    {
        $this->pythonScript .= "{$nodeName}.getParam('fps').setValue({$fps})" . PHP_EOL;
    }

    /**
     * 设置帧范围模式
     * @param $nodeName
     * @param $frameRangeMode
     */
    protected function setFrameRangeMode($nodeName, $frameRangeMode)
    {
        switch ($frameRangeMode) {
            case 'input':
                // Union of input ranges (union): The union of all inputs frame ranges will be rendered.
                $frameRangeModeNumber = 0;
                break;
            case 'project':
                // Project frame range (project): The frame range delimited by the frame range of the project will be rendered.
                $frameRangeModeNumber = 1;
                break;
            default:
            case 'manual':
                // Manual (manual): The frame range will be the one defined by the first frame and last frame parameters.
                $frameRangeModeNumber = 2;
                break;
        }
        $this->pythonScript .= "{$nodeName}.getParam('frameRange').setValue({$frameRangeModeNumber})" . PHP_EOL;
    }

    /**
     * 设置起始帧数
     * @param $nodeName
     * @param $frameNumber
     */
    protected function setFirstFrame($nodeName, $frameNumber)
    {
        $this->pythonScript .= "{$nodeName}.getParam('firstFrame').setValue({$frameNumber})" . PHP_EOL;
    }

    /**
     * 设置结束帧数
     * @param $nodeName
     * @param $frameNumber
     */
    protected function setLastFrame($nodeName, $frameNumber)
    {
        $this->pythonScript .= "{$nodeName}.getParam('lastFrame').setValue({$frameNumber})" . PHP_EOL;
    }

    /**
     * 处理视频
     * @param $param
     */
    protected function video($param)
    {
        $mustParamKeys = ['node_name', 'filename', 'read_path', 'render_path'];
        if ($this->checkParam($param, $mustParamKeys)) {
            $readNodeName = "read_{$param["node_name"]}";
            $writeNodeName = "write_{$param["node_name"]}";

            // 创建读取节点
            $this->createReadNode($readNodeName, $param["read_path"]);

            // 创建写出节点
            $this->createWriteNode($writeNodeName, $param["render_path"]);

            $this->setFormatType($writeNodeName, 0);
            $this->setVideoFormat($writeNodeName);
            $this->setVideoCodec($writeNodeName);
            $this->setVideoFPS($writeNodeName, $param["fps"]);

            // 连接两个节点
            $this->connectInput($writeNodeName, $readNodeName);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 处理缩略图
     * @param $param
     * @return bool
     */
    protected function thumbnail($param)
    {
        $mustParamKeys = ['node_name', 'filename', 'read_path', 'render_path'];
        if ($this->checkParam($param, $mustParamKeys)) {
            $readNodeName = "read_{$param["node_name"]}";
            $writeNodeName = "write_{$param["node_name"]}";

            // 创建读取节点
            $this->createReadNode($readNodeName, $param["read_path"]);

            // 创建写出节点
            $this->createWriteNode($writeNodeName, $param["render_path"]);
            $this->setFormatType($writeNodeName, 0);
            //$this->setInputColorSpace($writeNodeName, 'srgb');
            $this->setOutputColorSpace($writeNodeName, 'srgb');
            $this->setFrameRangeMode($writeNodeName, 'manual');
            $this->setFirstFrame($writeNodeName, 1);
            $this->setLastFrame($writeNodeName, 1);

            // 连接两个节点
            $this->connectInput($writeNodeName, $readNodeName);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 连接两个节点
     * @param $fromNodeName
     * @param $toNodeName
     */
    protected function connectInput($fromNodeName, $toNodeName)
    {
        $this->pythonScript .= "{$fromNodeName}.connectInput(0,{$toNodeName})" . PHP_EOL;
    }

    /**
     * 生成Python 转码模板
     * @param $param
     * @return string
     */
    public function generate($param)
    {
        if (array_key_exists("video", $param)) {
            if (!$this->video($param["video"])) {
                return false;
            };
        }
        if (array_key_exists("thumbnail", $param)) {
            if (!$this->thumbnail($param["thumbnail"])) {
                return false;
            };
        }
        return $this->pythonScript;
    }
}