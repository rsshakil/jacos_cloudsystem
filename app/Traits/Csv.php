<?php
namespace App\Traits;

trait Csv
{

    /**
     * CSVファイルを生成する
     * @param $filePath
     */
    public static function createCsv($filePath, $bom=false)
    {
        $csv_file_path = storage_path($filePath);
        $result = fopen($csv_file_path, 'w');
        if ($result === false) {
            throw new Exception('ファイルの書き込みに失敗しました。');
        }
        if ($bom) {
            // BOM をつける
            fwrite($result, pack('C*', 0xEF, 0xBB, 0xBF));
        }
        fclose($result);

        return $csv_file_path;
    }

    /**
     * CSVファイルに書き出す
     * @param $filepath
     * @param $records
     */
    public static function writeAll($filePath, $dataArray)
    {
        $result = fopen($filePath, 'a');

        // ファイルに書き出し
        foreach ($dataArray as $values) {
            fputcsv($result, $values);
        }

        fclose($result);
    }

    /**
     * CSVファイルに書き出す
     * @param $filepath
     * @param $records
     */
    public static function write($filePath, $records)
    {
        $result = fopen($filePath, 'a');

        // ファイルに書き出し
        fputcsv($result, $records);

        fclose($result);
    }

    /**
     * CSVファイルの削除
     * @param $filename
     */
    public static function purge($filePath)
    {
        return unlink(storage_path($filePath));
    }
}
