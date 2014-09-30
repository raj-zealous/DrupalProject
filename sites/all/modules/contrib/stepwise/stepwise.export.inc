<?php
/**
 * @file
 *
 */

/**
 *
 */
class StepwiseModuleExport {
  protected $files;
  protected $module_name;
  protected $configuration;

  /**
   * Constructor.
   *
   * @param $filename
   * @param $workflow
   */
  function __construct($configuration) {
    $this->module_name = $configuration->name;
    $this->configuration = $configuration;
    $this->files = array(
      'info' => new StepwiseInfoFile($configuration->name, $configuration),
      'module' => new StepwiseModuleFile($configuration->name, $configuration),
      'stepwise' => new StepwiseIncFile($configuration->name, 'stepwise', $configuration),
    );
  }

  /**
   *
   */
  public function export() {
    if (ob_get_level()) {
      ob_end_clean();
    }

    drupal_add_http_header('Content-type', 'application/x-tar');
    drupal_add_http_header('Content-Disposition', 'attachment; filename="' . $this->module_name . '.tar"');
    drupal_send_headers();

    foreach ($this->files as $file) {
      $file->exportCode();
      $file_name = $file->getFileName();
      $code = $file->getCode();
      print  $this->tarFileCreate("{$this->module_name}/$file_name", $code);
    }

    print pack("a1024","");
    exit;
  }

  /**
   *
   */
  protected  function tarFileCreate($name, $contents) {
    $tar = '';
    $binary_data_first = pack("a100a8a8a8a12A12",
      $name,
      '100644 ', // File permissions
      '   765 ', // UID,
      '   765 ', // GID,
      sprintf("%11s ", decoct(strlen($contents))), // Filesize,
      sprintf("%11s", decoct(REQUEST_TIME)) // Creation time
    );
    $binary_data_last = pack("a1a100a6a2a32a32a8a8a155a12", '', '', '', '', '', '', '', '', '', '');

    $checksum = 0;
    for ($i = 0; $i < 148; $i++) {
      $checksum += ord(substr($binary_data_first, $i, 1));
    }
    for ($i = 148; $i < 156; $i++) {
      $checksum += ord(' ');
    }
    for ($i = 156, $j = 0; $i < 512; $i++, $j++) {
      $checksum += ord(substr($binary_data_last, $j, 1));
    }

    $tar .= $binary_data_first;
    $tar .= pack("a8", sprintf("%6s ", decoct($checksum)));
    $tar .= $binary_data_last;

    $buffer = str_split($contents, 512);
    foreach ($buffer as $item) {
      $tar .= pack("a512", $item);
    }
    return $tar;
  }
}

/**
 *
 */
abstract class StepwiseFile {
  protected $filename;
  protected $code;
  protected $module_name;
  protected $configuration;

  abstract function exportCode();

  public function getFileName() {
    return $this->filename;
  }

  public function getCode() {
    return $this->code;
  }
}

/**
 *
 */
class StepWiseInfoFile extends StepwiseFile {

  /**
   *
   *
   * @param $module_name
   * @param $extension
   */
  function __construct($module_name, $configuration) {
    $this->configuration = $configuration;
    $this->module_name = $module_name;
    $this->filename = "$module_name.info";
  }

  /**
   *
   *
   * @param $code
   */
  function exportCode() {
    $configuration = $this->configuration;
    $this->code = "name = $configuration->name\n";
    $this->code .= "description = $configuration->description\n";
    $this->code .= empty($configuration->group) ? "group = stepwise\n" : "group = $configuration->group\n";
    $this->code .= "core = 7.x\n";
    $this->code .= "files[] = $configuration->name.stepwise.inc\n";
    return $this->code;
  }
}

/**
 *
 */
class StepWiseModuleFile extends StepwiseFile {

  /**
   *
   *
   * @param $module_name
   * @param $extension
   */
  function __construct($module_name, $configuration) {
    $this->configuration = $configuration;
    $this->module_name = $module_name;
    $this->filename = "$module_name.module";
  }

  /**
   *
   *
   * @param $code
   */
  function exportCode() {
    $this->code = "<?php\n";
    return $this->code;
  }
}

/**
 *
 */
class StepWiseIncFile extends StepwiseFile {
  /**
   *
   *
   * @param $module_name
   * @param $extension
   */
  function __construct($module_name, $type, $configuration) {
    $this->configuration = $configuration;
    $this->module_name = $module_name;
    $this->filename = "$module_name.$type.inc";
  }

  /**
   *
   *
   * @param $code
   */
  function exportCode() {
    $configuration = $this->configuration;
    $this->code = "<?php\n";
    $this->code .= "function {$configuration->name}_stepwise_configuration_info() {\n";
    $this->code .= '$items["' . $configuration->name . '"] = ' . var_export((array)$configuration, TRUE) . ";\n";
    $this->code .= 'return $items;' . "\n}\n";
    return $this->code;
  }
}
