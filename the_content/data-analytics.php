<?php
  /**
   * Queries the Analytics Reporting API V4.
   *
   * @param service An authorized Analytics Reporting API V4 service object.
   * @return The Analytics Reporting API V4 response.
   */
  function getReport($analytics) {

  	// Replace with your view ID, for example XXXX.
  	$VIEW_ID = "XXXX";  //OO

  	// Create the DateRange object.
  	$dateRange = new Google_Service_AnalyticsReporting_DateRange();
  	$dateRange->setStartDate('1daysago');
  	$dateRange->setEndDate('today');

  	// Create the Metrics object.
  	$pageviews = new Google_Service_AnalyticsReporting_Metric();
  	$pageviews->setExpression("ga:pageviews");
  	$pageviews->setAlias("pageviews");

      // Create the Metrics object.
      $sessions = new Google_Service_AnalyticsReporting_Metric();
      $sessions->setExpression("ga:sessions");
      $sessions->setAlias("sessions");

  	$ordering = new Google_Service_AnalyticsReporting_OrderBy();
    	$ordering->setFieldName("ga:pageviews");
    	$ordering->setOrderType("VALUE");   
    	$ordering->setSortOrder("DESCENDING");

    	//Create the Dimensions objects.
   	// $browser = new Google_Service_AnalyticsReporting_Dimension();
   	// $browser->setName("ga:pageTitle");

    	$url = new Google_Service_AnalyticsReporting_Dimension();
    	$url->setName("ga:pagePath");

    // Create the ReportRequest object.
    	$request = new Google_Service_AnalyticsReporting_ReportRequest();
    	$request->setViewId($VIEW_ID);
    	$request->setDateRanges($dateRange);
    	$request->setDimensions($url);
  	$request->setOrderBys($ordering);
    	$request->setMetrics(array($pageviews, $sessions));

    	$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    	$body->setReportRequests( array( $request) );
    return $analytics->reports->batchGet( $body );
  }

  /**
   * Parses and prints the Analytics Reporting API V4 response.
   *
   * @param An Analytics Reporting API V4 response.
   */
  function printResults($reports) {
    for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
      $report = $reports[ $reportIndex ];
      $header = $report->getColumnHeader();
      $dimensionHeaders = $header->getDimensions();
      $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
      $rows = $report->getData()->getRows();

      for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
        $row = $rows[ $rowIndex ];
        $dimensions = $row->getDimensions();
        $metrics = $row->getMetrics();

        for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
          print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
        }

        for ($j = 0; $j < count($metrics); $j++) {
          $values = $metrics[$j]->getValues();
          for ($k = 0; $k < count($values); $k++) {
            $entry = $metricHeaders[$k];
            print($entry->getName() . ": " . $values[$k] . "\n");
          }
        }
      }
    }
  }

  function arrayResults($reports) {
    $arrayReport = array();

    for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
      $report = $reports[ $reportIndex ];
      $header = $report->getColumnHeader();
      $dimensionHeaders = $header->getDimensions();
      $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
      $rows = $report->getData()->getRows();

      for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
        $row = $rows[ $rowIndex ];
        $dimensions = $row->getDimensions();
        $metrics = $row->getMetrics();

        $element = array();

        for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
          $element[$dimensionHeaders[$i]] = $dimensions[$i];
        }

        for ($j = 0; $j < count($metrics); $j++) {
          $values = $metrics[$j]->getValues();
          for ($k = 0; $k < count($values); $k++) {
            $entry = $metricHeaders[$k];
            $element[$entry->getName()] = $values[$k];
          }
        }

        $arrayReport[] = $element;
      }
    }
    return $arrayReport;
  }
?>