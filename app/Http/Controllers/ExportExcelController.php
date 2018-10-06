<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class ExportExcelController extends Controller
{
    public function ExportExcel()
    {
    	$excel = new \PHPExcel();        

        $excel->createSheet();
        $excel->setActiveSheetIndex(1);
        $excel->getActiveSheet()->setTitle('ChartTest');

        $objWorksheet = $excel->getActiveSheet();
        $objWorksheet->fromArray(
                array(
                    array('', 'Rainfall (mm)', 'Temperature (°F)', 'Humidity (%)'),
                    array('Jan', 78, 52, 61),
                    array('Feb', 64, 54, 62),
                    array('Mar', 62, 57, 63),
                    array('Apr', 21, 62, 59),
                    array('May', 11, 75, 60),
                    array('Jun', 1, 75, 57),
                    array('Jul', 1, 79, 56),
                    array('Aug', 1, 79, 59),
                    array('Sep', 10, 75, 60),
                    array('Oct', 40, 68, 63),
                    array('Nov', 69, 62, 64),
                    array('Dec', 89, 57, 66),
                )
        );

        $dataseriesLabels1 = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'ChartTest!$B$1', NULL, 1), //  Temperature
        );
        $dataseriesLabels2 = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'C$1', NULL, 1), //  Rainfall
        );
        $dataseriesLabels3 = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'D$1', NULL, 1), //  Humidity
        );

        $xAxisTickValues = array(
            new \PHPExcel_Chart_DataSeriesValues('String', '!$A$2:$A$13', NULL, 12), //  Jan to Dec
        );

        $dataSeriesValues1 = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', '!$B$2:$B$13', NULL, 12),
        );

        //  Build the dataseries
        $temperatura = new \PHPExcel_Chart_DataSeries(
                \PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
                \PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED, // plotGrouping
                range(0, count($dataSeriesValues1) - 1), // plotOrder
                $dataseriesLabels1, // plotLabel
                $xAxisTickValues, // plotCategory
                $dataSeriesValues1                              // plotValues
        );
        //  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $temperatura->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COL);

        $dataSeriesValues2 = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', '!$C$2:$C$13', NULL, 12),
        );

        //  Build the dataseries
        $rainfall = new \PHPExcel_Chart_DataSeries(
                \PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
                \PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
                range(0, count($dataSeriesValues2) - 1), // plotOrder
                $dataseriesLabels2, // plotLabel
                NULL, // plotCategory
                $dataSeriesValues2                              // plotValues
        );

        $dataSeriesValues3 = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', '!$D$2:$D$13', NULL, 12),
        );

        //  Build the dataseries
        $humidity = new \PHPExcel_Chart_DataSeries(
                \PHPExcel_Chart_DataSeries::TYPE_AREACHART, // plotType
                \PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
                range(0, count($dataSeriesValues2) - 1), // plotOrder
                $dataseriesLabels3, // plotLabel
                NULL, // plotCategory
                $dataSeriesValues3                              // plotValues
        );


        //  Set the series in the plot area
        $plotarea = new \PHPExcel_Chart_PlotArea(NULL, array($temperatura, $rainfall, $humidity));
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
        $title = new \PHPExcel_Chart_Title('Grafica anhelada maternofetal :(');

        //  Create the chart
        $chart = new \PHPExcel_Chart(
                'chart1', // name
                $title, // title
                $legend, // legend
                $plotarea, // plotArea
                true, // plotVisibleOnly
                0, // displayBlanksAs
                NULL, // xAxisLabel
                NULL            // yAxisLabel
        );

        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('F2');
        $chart->setBottomRightPosition('O16');

        //  Add the chart to the worksheet
        $objWorksheet->addChart($chart);

        $writer = new \PHPExcel_Writer_Excel2007($excel);
        $writer->setIncludeCharts(TRUE);

        // Save the file.
        $writer->save(storage_path().'/file.xlsx');
    }
}
