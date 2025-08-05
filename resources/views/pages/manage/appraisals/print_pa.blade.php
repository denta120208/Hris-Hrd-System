<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
    <title>{{ $appraisal_code }}</title>
    <style type="text/css">
      @media print {
        @page {
          /* width: 250mm;
          height: 350mm; */
          size: A3;
        }

        .pagebreak {
          page-break-before: always;
        }
      }

      html {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 11pt;
        background-color: white
      }

      a.comment-indicator:hover+div.comment {
        background: #ffd;
        position: absolute;
        display: block;
        border: 1px solid black;
        padding: 0.5em
      }

      a.comment-indicator {
        background: red;
        display: inline-block;
        border: 1px solid black;
        width: 0.5em;
        height: 0.5em
      }

      div.comment {
        display: none
      }

      table {
        border-collapse: collapse;
        page-break-after: always
      }

      .gridlines td {
        border: 1px dotted black
      }

      .gridlines th {
        border: 1px dotted black
      }

      .b {
        text-align: center
      }

      .e {
        text-align: center
      }

      .f {
        text-align: right
      }

      .inlineStr {
        text-align: left
      }

      .n {
        text-align: right
      }

      .s {
        text-align: left
      }

      td.style0 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style0 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style1 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style1 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style3 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style3 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style4 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style4 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style5 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style5 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style6 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style6 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style7 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style7 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style8 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style8 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style9 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000;
        padding: 5px;
      }

      th.style9 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style10 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style10 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style11 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white;
      }

      th.style11 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style12 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style12 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style13 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style13 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style14 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style14 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style15 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style15 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style16 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style16 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style17 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style17 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style18 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style18 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style19 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style19 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style20 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style20 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style21 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style21 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style22 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style22 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style23 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style23 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style24 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style24 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style25 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style25 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style26 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style26 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style27 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style27 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style28 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style28 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style29 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style29 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style30 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style30 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style31 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style31 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style32 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style32 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style33 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style33 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style34 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style34 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style35 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 3px double #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: 3px double #000000 !important;
        border-right: 3px double #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style35 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 3px double #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: 3px double #000000 !important;
        border-right: 3px double #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style36 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 3px double #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: 3px double #000000 !important;
        border-right: 3px double #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style36 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 3px double #000000 !important;
        border-top: 3px double #000000 !important;
        border-left: 3px double #000000 !important;
        border-right: 3px double #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style37 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style37 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style38 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style38 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style39 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style39 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style40 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      th.style40 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      td.style41 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFFF99
      }

      th.style41 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFFF99
      }

      td.style42 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFFF99
      }

      th.style42 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFFF99
      }

      td.style43 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFFF99
      }

      th.style43 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFFF99
      }

      td.style44 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style44 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style45 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style45 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style46 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style46 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style47 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style47 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style48 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 14pt;
        background-color: white
      }

      th.style48 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 14pt;
        background-color: white
      }

      td.style49 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style49 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style50 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style50 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style51 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style51 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style52 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style52 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style53 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style53 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style54 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000;
        width: 10%;
      }

      th.style54 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000;
      }

      td.style55 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style55 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style56 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style56 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style57 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      th.style57 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: white
      }

      td.style58 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style58 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style59 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      th.style59 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 9pt;
        background-color: #FFC000
      }

      td.style60 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      th.style60 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      td.style61 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      th.style61 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      table.sheet0 col.col0 {
        width: 17.62222202pt
      }

      table.sheet0 col.col1 {
        width: 31.17777742pt
      }

      table.sheet0 col.col2 {
        width: 56.93333268pt
      }

      table.sheet0 col.col3 {
        width: 64.38888815pt
      }

      table.sheet0 col.col4 {
        width: 49.47777721pt
      }

      table.sheet0 col.col5 {
        width: 44.73333282pt
      }

      table.sheet0 col.col6 {
        width: 50.15555498pt
      }

      table.sheet0 col.col7 {
        width: 56.25555491pt
      }

      table.sheet0 col.col8 {
        width: 48.12222167pt
      }

      table.sheet0 col.col9 {
        width: 48.12222167pt
      }

      table.sheet0 col.col10 {
        width: 105.05555435pt
      }

      table.sheet0 col.col11 {
        width: 17.62222202pt
      }

      table.sheet0 col.col12 {
        width: 61.67777707pt
      }

      table.sheet0 col.col13 {
        width: 54.2222216pt
      }

      table.sheet0 col.col14 {
        width: 54.2222216pt
      }

      table.sheet0 col.col15 {
        width: 64.38888815pt
      }

      table.sheet0 col.col16 {
        width: 64.38888815pt
      }

      table.sheet0 col.col17 {
        width: 64.38888815pt
      }

      table.sheet0 col.col18 {
        width: 64.38888815pt
      }

      table.sheet0 tr {
        height: 12.75pt
      }

      table.sheet0 tr.row1 {
        height: 18.75pt
      }

      table.sheet0 tr.row2 {
        height: 18.75pt
      }

      table.sheet0 tr.row3 {
        height: 18.75pt
      }

      table.sheet0 tr.row4 {
        height: 18pt
      }

      table.sheet0 tr.row5 {
        height: 20.25pt
      }

      table.sheet0 tr.row6 {
        height: 21.75pt
      }

      table.sheet0 tr.row7 {
        height: 21.75pt
      }

      table.sheet0 tr.row8 {
        height: 24pt
      }

      table.sheet0 tr.row9 {
        height: 11.1pt
      }

      table.sheet0 tr.row10 {
        height: 17.85pt
      }

      table.sheet0 tr.row11 {
        height: 15.6pt
      }

      table.sheet0 tr.row12 {
        height: 15.95pt
      }

      table.sheet0 tr.row13 {
        height: 18.75pt
      }

      table.sheet0 tr.row14 {
        height: 18.75pt
      }

      table.sheet0 tr.row15 {
        height: 18.75pt
      }

      table.sheet0 tr.row16 {
        height: 18.75pt
      }

      table.sheet0 tr.row17 {
        height: 18.75pt
      }

      table.sheet0 tr.row18 {
        height: 18.75pt
      }

      table.sheet0 tr.row19 {
        height: 18.75pt
      }

      table.sheet0 tr.row20 {
        height: 18.75pt
      }

      table.sheet0 tr.row21 {
        height: 18.75pt
      }

      table.sheet0 tr.row22 {
        height: 18.75pt
      }

      table.sheet0 tr.row23 {
        height: 18.75pt
      }

      table.sheet0 tr.row24 {
        height: 18.75pt
      }

      table.sheet0 tr.row25 {
        height: 18.75pt
      }

      table.sheet0 tr.row26 {
        height: 18.75pt
      }

      table.sheet0 tr.row27 {
        height: 18.75pt
      }

      table.sheet0 tr.row28 {
        height: 18.75pt
      }

      table.sheet0 tr.row29 {
        height: 15.95pt
      }

      table.sheet0 tr.row30 {
        height: 15.95pt
      }

      table.sheet0 tr.row31 {
        height: 19.15pt
      }

      table.sheet0 tr.row32 {
        height: 15.95pt
      }

      table.sheet0 tr.row33 {
        height: 15.95pt
      }

      table.sheet0 tr.row34 {
        height: 15.95pt
      }

      table.sheet0 tr.row35 {
        height: 15.95pt
      }

      table.sheet0 tr.row36 {
        height: 9.75pt
      }

      table.sheet0 tr.row37 {
        height: 19.15pt
      }

      table.sheet0 tr.row38 {
        height: 19.15pt
      }

      table.sheet0 tr.row39 {
        height: 14.45pt
      }

      table.sheet0 tr.row40 {
        height: 14.45pt
      }

      table.sheet0 tr.row41 {
        height: 14.45pt
      }

      table.sheet0 tr.row42 {
        height: 14.45pt
      }

      table.sheet0 tr.row43 {
        height: 9.75pt
      }

      table.sheet0 tr.row44 {
        height: 18pt
      }

      table.sheet0 tr.row45 {
        height: 18pt
      }

      table.sheet0 tr.row46 {
        height: 18pt
      }

      table.sheet0 tr.row47 {
        height: 18pt
      }

      table.sheet0 tr.row48 {
        height: 18pt
      }

      table.sheet0 tr.row49 {
        height: 18pt
      }

      table.sheet0 tr.row50 {
        height: 18pt
      }

      table.sheet0 tr.row51 {
        height: 18pt
      }

      table.sheet0 tr.row52 {
        height: 18pt
      }

      .column1page1 {
        width: 5%;
      }

      td.style6page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style6page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style7page2 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 14pt;
        background-color: white
      }

      th.style7page2 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 14pt;
        background-color: white
      }

      td.style8page2 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style8page2 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style9page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        width: 5%;
      }

      th.style9page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style10page2 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style10page2 {
        vertical-align: bottom;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style11page2 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding-left: 5px;
      }

      th.style11page2 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style12page2 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style12page2 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style13page2 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style13page2 {
        vertical-align: bottom;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style14page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style14page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style15page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style15page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style16page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style16page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style17page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style17page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style18page2 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style18page2 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style19page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      th.style19page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style20page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style20page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style23page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      th.style23page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style24page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      th.style24page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style25page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      th.style25page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style26page2 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style26page2 {
        vertical-align: middle;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style27page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000;
        padding-left: 5px;
      }

      th.style27page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      td.style28page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      th.style28page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style29page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style29page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style37page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style37page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style38page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style38page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style40page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style40page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style41page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      th.style41page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style43page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      th.style43page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style44page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style44page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style46page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style46page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style47page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      th.style47page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      td.style48page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style48page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style50page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding-left: 5px;
      }

      th.style50page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style51page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      th.style51page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      td.style52page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style52page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style53page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style53page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style54page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      th.style54page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style56page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC;
        padding-left: 5px;
      }

      th.style56page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFCC
      }

      td.style57page2 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding-left: 5px;
      }

      th.style57page2 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style59page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 14pt;
        background-color: white
      }

      th.style59page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 14pt;
        background-color: white
      }

      td.style60page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      th.style60page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial';
        font-size: 10pt;
        background-color: white
      }

      td.style61page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      th.style61page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      td.style62page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000;
        padding: 5px;
      }

      th.style62page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      td.style64page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000;
        width: 5%;
      }

      th.style64page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000
      }

      td.style65page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding-left: 5px;
      }

      th.style65page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style66page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style66page2 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style67page2 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000;
        padding-left: 5px;
      }

      th.style67page2 {
        vertical-align: middle;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFC000;
      }

      td.style68page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style68page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style69page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding-left: 5px;
      }

      th.style69page2 {
        vertical-align: middle;
        text-align: left;
        padding-left: 0px;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: none #000000;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      table.sheet0page2 tr {
        height: 12.75pt
      }

      table.sheet0page2 tr.row1 {
        height: 18pt
      }

      table.sheet0page2 tr.row2 {
        height: 12.75pt
      }

      table.sheet0page2 tr.row3 {
        height: 12.75pt
      }

      table.sheet0page2 tr.row4 {
        height: 12.75pt
      }

      table.sheet0page2 tr.row5 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row6 {
        height: 6.75pt
      }

      table.sheet0page2 tr.row7 {
        height: 21.75pt
      }

      table.sheet0page2 tr.row8 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row9 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row10 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row11 {
        height: 11.85pt
      }

      table.sheet0page2 tr.row12 {
        height: 16.35pt
      }

      table.sheet0page2 tr.row13 {
        height: 15pt
      }

      table.sheet0page2 tr.row14 {
        height: 21pt
      }

      table.sheet0page2 tr.row15 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row16 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row17 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row18 {
        height: 11.1pt
      }

      table.sheet0page2 tr.row19 {
        height: 15.6pt
      }

      table.sheet0page2 tr.row20 {
        height: 20.25pt
      }

      table.sheet0page2 tr.row21 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row22 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row23 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row24 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row25 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row26 {
        height: 20.25pt
      }

      table.sheet0page2 tr.row27 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row28 {
        height: 25.35pt
      }

      table.sheet0page2 tr.row29 {
        height: 23.25pt
      }

      table.sheet0page2 tr.row30 {
        height: 20.25pt
      }

      table.sheet0page2 tr.row31 {
        height: 9.75pt
      }

      table.sheet0page2 tr.row32 {
        height: 17.25pt
      }

      table.sheet0page2 tr.row33 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row34 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row35 {
        height: 20.1pt
      }

      table.sheet0page2 tr.row36 {
        height: 21pt
      }

      table.sheet0page2 tr.row37 {
        height: 21pt
      }

      table.sheet0page2 tr.row38 {
        height: 21pt
      }

      table.sheet0page2 tr.row39 {
        height: 21pt
      }

      table.sheet0page2 tr.row40 {
        height: 21pt
      }

      table.sheet0page2 tr.row41 {
        height: 21pt
      }

      table.sheet0page2 tr.row42 {
        height: 21pt
      }

      table.sheet0page2 tr.row43 {
        height: 14.25pt
      }

      .column6page2 {
        width: 15%;
      }

      td.style3page3 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #FF0000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style3page3 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #FF0000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style4page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style4page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style5page3 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style5page3 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style6page3 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 12pt;
        background-color: white
      }

      th.style6page3 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 12pt;
        background-color: white
      }

      td.style8page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #C0C0C0;
      }

      th.style8page3 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #C0C0C0
      }

      td.style9page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style9page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style10page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding: 4px;
      }

      th.style10page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style11page3 {
        vertical-align: top;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding: 4px;
      }

      th.style11page3 {
        vertical-align: top;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style12page3 {
        vertical-align: top;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFFF;
        padding: 4px;
      }

      th.style12page3 {
        vertical-align: top;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #FFFFFF
      }

      td.style13page3 {
        vertical-align: top;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding: 4px;
      }

      th.style13page3 {
        vertical-align: top;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style15page3 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #00B050;
        font-family: 'Century Gothic';
        font-size: 10pt;
        background-color: white
      }

      th.style15page3 {
        vertical-align: bottom;
        text-align: left;
        padding-left: 0px;
        border-bottom: none #000000;
        border-top: none #000000;
        border-left: none #000000;
        border-right: none #000000;
        font-weight: bold;
        color: #00B050;
        font-family: 'Century Gothic';
        font-size: 10pt;
        background-color: white
      }

      td.style25page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #C0C0C0
      }

      th.style25page3 {
        vertical-align: bottom;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #C0C0C0
      }

      td.style26page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      th.style26page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style27page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white;
        padding: 4px;
      }

      th.style27page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: white
      }

      td.style28page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #CCCCCC
      }

      th.style28page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #CCCCCC
      }

      td.style29page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #CCCCCC;
        padding: 4px;
      }

      th.style29page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #CCCCCC
      }

      td.style30page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #CCCCCC;
        width: 5%;
      }

      th.style30page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: none #000000;
        border-top: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #CCCCCC
      }

      td.style31page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #CCCCCC
      }

      th.style31page3 {
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #000000 !important;
        border-top: none #000000;
        border-left: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        font-weight: bold;
        color: #000000;
        font-family: 'Arial Narrow';
        font-size: 10pt;
        background-color: #CCCCCC
      }

      table.sheet0page3 col.col0 {
        width: 17.62222202pt
      }

      table.sheet0page3 col.col1 {
        width: 84.04444348pt
      }

      table.sheet0page3 col.col2 {
        width: 91.49999895pt
      }

      table.sheet0page3 col.col3 {
        width: 103.02222104pt
      }

      table.sheet0page3 col.col4 {
        width: 89.46666564pt
      }

      table.sheet0page3 col.col5 {
        width: 128.7777763pt
      }

      table.sheet0page3 col.col6 {
        width: 42pt
      }

      table.sheet0page3 tr {
        height: 12.75pt
      }

      table.sheet0page3 tr.row1 {
        height: 15.75pt
      }

      table.sheet0page3 tr.row2 {
        height: 12.75pt
      }

      table.sheet0page3 tr.row3 {
        height: 12.75pt
      }

      table.sheet0page3 tr.row4 {
        height: 12.75pt
      }

      table.sheet0page3 tr.row5 {
        height: 12.75pt
      }

      table.sheet0page3 tr.row6 {
        height: 90pt
      }

      table.sheet0page3 tr.row7 {
        height: 14.85pt
      }

      table.sheet0page3 tr.row8 {
        height: 79.15pt
      }

      table.sheet0page3 tr.row9 {
        height: 17.1pt
      }

      table.sheet0page3 tr.row10 {
        height: 123pt
      }

      table.sheet0page3 tr.row11 {
        height: 12.75pt
      }
    </style>
  </head>
  <body>
    <?php
        $kode_print = $appraisal_code;
        $nama_evaluators = strtolower($emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname);
        $fix_nama_evaluators = ucwords($nama_evaluators);
        $job_title = strtolower($emp->job_title->job_title);
        $fix_job_title = ucwords($job_title);
        $dataDept = \DB::table("job_category")->where("id", $emp->eeo_cat_code)->first();
        $dataLocation = \DB::table("location")->where("id", $emp->location_id)->first();

        $dataTglPenilaian = null;
        $dataAppraisalCategorys = \DB::table("appraisal_category")->get();
        foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory) {
            $dataAppraisals = \DB::table("appraisal")->where("type_code", $kode_print)->where("appraisal_cat", $dataAppraisalCategory->id)->orderBy("sub_appraisal", "DESC")->get();
            $arrIdAppraisal = [];
            foreach($dataAppraisals as $key2 => $item) {
                $dataEmpApparaisalValue = \DB::table("emp_appraisal")->where("emp_number", $emp->emp_number)->where("emp_evaluator", $id_evaluator)->where("appraisal_id", $item->id)->where("period", $year)->first();
                $dataAppraisals[$key2]->dataEmpApparaisalValue = empty($dataEmpApparaisalValue->appraisal_value) ? 0 : $dataEmpApparaisalValue->appraisal_value;
                $dataTglPenilaian = empty($dataEmpApparaisalValue->created_at) ? 0 : date("d-m-Y", strtotime($dataEmpApparaisalValue->created_at));
                array_push($arrIdAppraisal, $item->id);
            }            
            $dataSumEmpApparaisals = \DB::table("emp_appraisal")->where("emp_number", $emp->emp_number)->where("emp_evaluator", $id_evaluator)->whereIn("appraisal_id", $arrIdAppraisal)->where("period", $year)->get();
            $sumEmpApparaisal = 0;
            foreach($dataSumEmpApparaisals as $dataSumEmpApparaisal) {
              $sumEmpApparaisal += $dataSumEmpApparaisal->appraisal_value;
            }
            $dataAppraisalCategorys[$key]->sumEmpApparaisal = $sumEmpApparaisal;
            $dataAppraisalCategorys[$key]->dataAppraisals = $dataAppraisals;
            $dataAppraisalCategorys[$key]->countAppraisal = count($dataAppraisals);
        }

        $report_to_emp_evaluator_lvl1 = DB::table("emp_reportto AS a")->select("a.*", "b.emp_firstname", "b.emp_middle_name", "b.emp_lastname")->leftJoin("employee AS b", "b.emp_number", "=", "a.erep_sub_emp_number")->where("a.erep_sub_emp_number", $id_evaluator)->where("a.erep_reporting_mode", 1)->first();
        $report_to_emp_evaluator_lvl2 = empty($report_to_emp_evaluator_lvl1) ? null : DB::table("emp_reportto AS a")->select("a.*", "b.emp_firstname", "b.emp_middle_name", "b.emp_lastname")->leftJoin("employee AS b", "b.emp_number", "=", "a.erep_sub_emp_number")->where("a.erep_sub_emp_number", $report_to_emp_evaluator_lvl1->erep_sup_emp_number)->where("a.erep_reporting_mode", 1)->first();
        if(empty($report_to_emp_evaluator_lvl2)) {
            $report_to_emp_evaluator_lvl2 = $report_to_emp_evaluator_lvl1;
        }
        $report_to_emp_evaluator_lvl3 = empty($report_to_emp_evaluator_lvl2) ? null : DB::table("emp_reportto AS a")->select("a.*", "b.emp_firstname", "b.emp_middle_name", "b.emp_lastname")->leftJoin("employee AS b", "b.emp_number", "=", "a.erep_sub_emp_number")->where("a.erep_sub_emp_number", $report_to_emp_evaluator_lvl2->erep_sup_emp_number)->where("a.erep_reporting_mode", 1)->first();
        if(empty($report_to_emp_evaluator_lvl3)) {
            $report_to_emp_evaluator_lvl3 = $report_to_emp_evaluator_lvl2;
        }
        $report_to_emp_evaluator_lvl4 = empty($report_to_emp_evaluator_lvl3) ? null : DB::table("emp_reportto AS a")->select("a.*", "b.emp_firstname", "b.emp_middle_name", "b.emp_lastname")->leftJoin("employee AS b", "b.emp_number", "=", "a.erep_sub_emp_number")->where("a.erep_sub_emp_number", $report_to_emp_evaluator_lvl3->erep_sup_emp_number)->where("a.erep_reporting_mode", 1)->first();
        if(empty($report_to_emp_evaluator_lvl4)) {
            $report_to_emp_evaluator_lvl4 = $report_to_emp_evaluator_lvl3;
        }
        $report_to_emp_evaluator_lvl5 = empty($report_to_emp_evaluator_lvl4) ? null : DB::table("emp_reportto AS a")->select("a.*", "b.emp_firstname", "b.emp_middle_name", "b.emp_lastname")->leftJoin("employee AS b", "b.emp_number", "=", "a.erep_sub_emp_number")->where("a.erep_sub_emp_number", $report_to_emp_evaluator_lvl4->erep_sup_emp_number)->where("a.erep_reporting_mode", 1)->first();
        if(empty($report_to_emp_evaluator_lvl5)) {
            $report_to_emp_evaluator_lvl5 = $report_to_emp_evaluator_lvl4;
        }
        $report_to_emp_evaluator_lvl6 = empty($report_to_emp_evaluator_lvl5) ? null : DB::table("emp_reportto AS a")->select("a.*", "b.emp_firstname", "b.emp_middle_name", "b.emp_lastname")->leftJoin("employee AS b", "b.emp_number", "=", "a.erep_sub_emp_number")->where("a.erep_sub_emp_number", $report_to_emp_evaluator_lvl5->erep_sup_emp_number)->where("a.erep_reporting_mode", 1)->first();
        if(empty($report_to_emp_evaluator_lvl6)) {
            $report_to_emp_evaluator_lvl6 = $report_to_emp_evaluator_lvl5;
        }
    ?>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0" width="100%">
      <tbody>
        <tr class="row1">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style48 s style48" colspan="9">Form Performance Appraisal</td>
          <td class="column2" rowspan="3" style="text-align: right;">
            <img src="{{ asset('images\metland_logo_transparant.png') }}">
          </td>
        </tr>
        <tr class="row2">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style28 s style28" colspan="10">PT. Metropolitan Land Tbk</td>
          <td class="column11 style2 null"></td>
          <td class="column12 style2 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row3">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style28 s style28" colspan="10">Periode: Desember {{ $year - 1 }} - November {{ $year }}</td>
          <td class="column11 style2 null"></td>
          <td class="column12 style2 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row4">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style3 null"></td>
          <td class="column2 style2 null"></td>
          <td class="column3 style2 null"></td>
          <td class="column4 style2 null"></td>
          <td class="column5 style2 null"></td>
          <td class="column6 style2 null"></td>
          <td class="column7 style2 null"></td>
          <td class="column8 style2 null"></td>
          <td class="column9 style2 null"></td>
          <td class="column10 style2 null"></td>
          <td class="column11 style2 null"></td>
          <td class="column12 style2 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row5">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style35 s style35" style="padding-left: 5px;" colspan="2">Nama</td>
          <td class="column3 style36 s style36" style="padding-left: 5px;" colspan="8">: {!! $fix_nama_evaluators !!}</td>
          <td class="column11">&nbsp;</td>
          <td class="column12 style4 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row6">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style35 s style35" style="padding-left: 5px;" colspan="2">Jabatan</td>
          <td class="column3 style36 s style36" style="padding-left: 5px;" colspan="8">: {{ $fix_job_title }}</td>
          <td class="column11">&nbsp;</td>
          <td class="column12 style4 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row7">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style35 s style35" style="padding-left: 5px;" colspan="2">Departemen</td>
          <td class="column3 style36 s style36" style="padding-left: 5px;" colspan="8">: {{ $dataDept->name }}</td>
          <td class="column11">&nbsp;</td>
          <td class="column12 style4 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row8">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style35 s style35" style="padding-left: 5px;" colspan="2">Unit / Proyek</td>
          <td class="column3 style36 s style36" style="padding-left: 5px;" colspan="8">: {{ $dataLocation->name }}</td>
          <td class="column11">&nbsp;</td>
          <td class="column12 style4 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row9">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style2 null"></td>
          <td class="column2 style2 null"></td>
          <td class="column3 style2 null"></td>
          <td class="column4 style2 null"></td>
          <td class="column5 style2 null"></td>
          <td class="column6 style2 null"></td>
          <td class="column7 style2 null"></td>
          <td class="column8 style2 null"></td>
          <td class="column9 style2 null"></td>
          <td class="column10 style2 null"></td>
          <td class="column11 style2 null"></td>
          <td class="column12 style2 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row10">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style58 s style58" rowspan="3">No</td>
          <td class="column2 style58 s style58" colspan="3" rowspan="3">Kriteria Penilaian</td>
          <td class="column5 style37 s style39" colspan="5">Nilai Maksimum ****</td>
          <td class="column10 style52 s style54" rowspan="3">Nilai Karyawan ***</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row11">
          <td class="column0">&nbsp;</td>
          <td class="column5 style9 s">PA 1</td>
          <td class="column6 style9 s">PA 2</td>
          <td class="column7 style9 s">PA 3</td>
          <td class="column8 style9 s">PA 4</td>
          <td class="column9 style9 s">PA 5</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row12">
          <td class="column0">&nbsp;</td>
          <td class="column5 style9 s">&nbsp;Staff</td>
          <td class="column6 style9 s">SPV – MM *</td>
          <td class="column7 style9 s">SPV – MM **</td>
          <td class="column8 style9 s">SM – GM</td>
          <td class="column9 style25 s">Vice Dir</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row13">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style10 n">1</td>
          <td class="column2 style55 s style57" style="padding-left: 5px;" colspan="3">Produktivitas</td>
          <td class="column5 style11 n">40</td>
          <td class="column6 style11 n">40</td>
          <td class="column7 style11 n">40</td>
          <td class="column8 style11 n">40</td>
          <td class="column9 style11 n">15</td>
          <?php
            $totalPenilaian = 0;
            $dataProduktivitas = 0;
            foreach($dataAppraisalCategorys as $dataAppraisalCategory) {
                if($dataAppraisalCategory->id == 1) {
                    $dataProduktivitas = (float) $dataAppraisalCategory->sumEmpApparaisal;
                }
            }
            $totalPenilaian += $dataProduktivitas;
          ?>
          <td class="column10 style10 null">{{ $dataProduktivitas }}</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row14">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style10 n">2</td>
          <td class="column2 style55 s style57" style="padding-left: 5px;" colspan="3">Kompetensi</td>
          <td class="column5 style11 n">25</td>
          <td class="column6 style11 n">15</td>
          <td class="column7 style11 n">15</td>
          <td class="column8 style11 n">15</td>
          <td class="column9 style11 n">15</td>
          <?php
            $dataKompetensi = 0;
            foreach($dataAppraisalCategorys as $dataAppraisalCategory) {
                if($dataAppraisalCategory->id == 2) {
                    $dataKompetensi = (float) $dataAppraisalCategory->sumEmpApparaisal;
                }
            }
            $totalPenilaian += $dataKompetensi;
          ?>
          <td class="column10 style10 null">{{ $dataKompetensi }}</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row15">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style10 n">3</td>
          <td class="column2 style55 s style57" style="padding-left: 5px;" colspan="3">Karakter</td>
          <td class="column5 style11 n">35</td>
          <td class="column6 style11 n">30</td>
          <td class="column7 style11 n">30</td>
          <td class="column8 style11 n">20</td>
          <td class="column9 style11 n">30</td>
          <?php
            $dataKarakter = 0;
            foreach($dataAppraisalCategorys as $dataAppraisalCategory) {
                if($dataAppraisalCategory->id == 3) {
                    $dataKarakter = (float) $dataAppraisalCategory->sumEmpApparaisal;
                }
            }
            $totalPenilaian += $dataKarakter;
          ?>
          <td class="column10 style10 null">{{ $dataKarakter }}</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row16">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style10 n">4</td>
          <td class="column2 style55 s style57" style="padding-left: 5px;" colspan="3">Kepemimpinan</td>
          <td class="column5 style11 n">0</td>
          <td class="column6 style11 n">15</td>
          <td class="column7 style11 n">15</td>
          <td class="column8 style11 n">25</td>
          <td class="column9 style11 n">40</td>
          <?php
            $dataKepemimpinan = 0;
            foreach($dataAppraisalCategorys as $dataAppraisalCategory) {
                if($dataAppraisalCategory->id == 4) {
                    $dataKepemimpinan = (float) $dataAppraisalCategory->sumEmpApparaisal;
                }
            }
            $totalPenilaian += $dataKepemimpinan;
          ?>
          <td class="column10 style10 null">{{ $dataKepemimpinan }}</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row17">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style59 s style59" colspan="4">Total Penilaian </td>
          <td class="column5 style27 f">100</td>
          <td class="column6 style27 f">100</td>
          <td class="column7 style27 f">100</td>
          <td class="column8 style27 f">100</td>
          <td class="column9 style27 f">100</td>
          <td class="column10 style27 null">{{ $totalPenilaian }}</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row18">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style41 s style43" style="padding-left: 5px;" colspan="10">Item Pengurangan Penilaian Akibat Pemberian Sanksi</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row19">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style15 n">1</td>
          <td class="column2 style44 s style46" style="padding-left: 5px;" colspan="3">Minus Surat Teguran </td>
          <td class="column5 style10 n">5</td>
          <td class="column6 style10 n">5</td>
          <td class="column7 style10 n">5</td>
          <td class="column8 style10 n">5</td>
          <td class="column9 style10 n">5</td>
          <td class="column10 style32 null style34" rowspan="4">{{ $data_punishment }}</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row20">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style15 n">2</td>
          <td class="column2 style44 s style46" style="padding-left: 5px;" colspan="3">Minus Surat Peringatan 1</td>
          <td class="column5 style10 n">10</td>
          <td class="column6 style10 n">10</td>
          <td class="column7 style10 n">10</td>
          <td class="column8 style10 n">10</td>
          <td class="column9 style10 n">10</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row21">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style15 n">3</td>
          <td class="column2 style44 s style46" style="padding-left: 5px;" colspan="3">Minus Surat Peringatan 2</td>
          <td class="column5 style10 n">25</td>
          <td class="column6 style10 n">25</td>
          <td class="column7 style10 n">25</td>
          <td class="column8 style10 n">25</td>
          <td class="column9 style10 n">25</td>
          <td class="column11 style2 null"></td>
          <td class="column12 style2 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row22">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style15 n">4</td>
          <td class="column2 style44 s style46" style="padding-left: 5px;" colspan="3">Minus Surat Peringatan 3</td>
          <td class="column5 style10 n">50</td>
          <td class="column6 style10 n">50</td>
          <td class="column7 style10 n">50</td>
          <td class="column8 style10 n">50</td>
          <td class="column9 style10 n">50</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        {{-- <tr class="row23">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style41 s style43" style="padding-left: 5px;" colspan="10">Item Pengurangan Penilaian Terhadap Pencapaian Ebitda</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row24">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style15 n">1</td>
          <td class="column2 style12 s" style="padding-left: 5px;">Minus Pencapaian Ebitda 95% s/d 99,9%</td>
          <td class="column3 style13 null"></td>
          <td class="column4 style14 null"></td>
          <td class="column5 style10 n">10</td>
          <td class="column6 style10 n">10</td>
          <td class="column7 style10 n">10</td>
          <td class="column8 style10 n">10</td>
          <td class="column9 style10 n">10</td>
          <td class="column10 style32 null style34" rowspan="3"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row25">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style15 n">2</td>
          <td class="column2 style12 s" style="padding-left: 5px;">Minus Pencapaian Ebitda 90% s/d 94,9%</td>
          <td class="column3 style13 null"></td>
          <td class="column4 style14 null"></td>
          <td class="column5 style10 n">15</td>
          <td class="column6 style10 n">15</td>
          <td class="column7 style10 n">15</td>
          <td class="column8 style10 n">15</td>
          <td class="column9 style10 n">15</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row26">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style15 n">3</td>
          <td class="column2 style12 s" style="padding-left: 5px;">Minus Pencapaian Ebitda &lt; 90%</td>
          <td class="column3 style13 null"></td>
          <td class="column4 style14 null"></td>
          <td class="column5 style10 n">20</td>
          <td class="column6 style10 n">20</td>
          <td class="column7 style10 n">20</td>
          <td class="column8 style10 n">20</td>
          <td class="column9 style10 n">20</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr> --}}
        <tr class="row27">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style29 s style31" colspan="9">Grand Total Penilaian</td>
          <td class="column10 style26 null"><b>{{ $totalPenilaian - $data_punishment }}</b></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row28">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style3 null"></td>
          <td class="column2 style2 null"></td>
          <td class="column3 style2 null"></td>
          <td class="column4 style2 null"></td>
          <td class="column5 style2 null"></td>
          <td class="column6 style2 null"></td>
          <td class="column7 style2 null"></td>
          <td class="column8 style2 null"></td>
          <td class="column9 style2 null"></td>
          <td class="column10 style2 null"></td>
          <td class="column11 style2 null"></td>
          <td class="column12 style2 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row30">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style16 s" colspan="2">Pelatihan yang pernah diikuti di tahun {{ $year }} *****</td>
          <td class="column3 style18 null"></td>
          <td class="column4 style18 null"></td>
          <td class="column5 style17 null"></td>
          <td class="column6 style17 null"></td>
          <td class="column7 style17 null"></td>
          <td class="column8 style17 null"></td>
          <td class="column9 style17 null"></td>
          <td class="column10 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row31">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style61 s style61" colspan="5">Judul Pelatihan</td>
          <td class="column6 null"></td>
          <td class="column7 style60 s style60" colspan="4">Saran Perbaikan</td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row32">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style50 null style50" colspan="5" rowspan="4"></td>
          <td class="column6 style17 null"></td>
          <td class="column7 style51 null style51" colspan="4" rowspan="12"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row33">
          <td class="column0">&nbsp;</td>
          <td class="column6 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row34">
          <td class="column0">&nbsp;</td>
          <td class="column6 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row35">
          <td class="column0">&nbsp;</td>
          <td class="column6 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row36">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style19 null"></td>
          <td class="column2 style17 null"></td>
          <td class="column3 style18 null"></td>
          <td class="column4 style18 null"></td>
          <td class="column5 style17 null"></td>
          <td class="column6 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row37">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style61 s style61" colspan="5">Status Pelatihan (Selesai/Tidak)</td>
          <td class="column6 style20 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row38">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style49 s style49" colspan="5" rowspan="6">&nbsp;</td>
          <td class="column6 style21 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row39">
          <td class="column0">&nbsp;</td>
          <td class="column6 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row40">
          <td class="column0">&nbsp;</td>
          <td class="column6 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row41">
          <td class="column0">&nbsp;</td>
          <td class="column6 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row42">
          <td class="column0">&nbsp;</td>
          <td class="column6 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row43">
          <td class="column0">&nbsp;</td>
          <td class="column6 style17 null"></td>
          <td class="column11 style5 null"></td>
          <td class="column12 style5 null"></td>
          <td class="column13 style5 null"></td>
          <td class="column14 style5 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row44">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style17 null"></td>
          <td class="column2 style22 null"></td>
          <td class="column3 style17 null"></td>
          <td class="column4 style17 null"></td>
          <td class="column5 style17 null"></td>
          <td class="column6 style17 null"></td>
          <td class="column7 style17 null"></td>
          <td class="column8 style17 null"></td>
          <td class="column9 style17 null"></td>
          <td class="column10 style17 null"></td>
          <td class="column11 style2 null"></td>
          <td class="column12 style2 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row45">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style40 s style40" style="padding-left: 5px;" colspan="10">Keterangan</td>
          <td class="column11 style2 null"></td>
          <td class="column12 style2 null"></td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row46">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style47 s style47" style="padding-left: 5px;" colspan="10">Surat Teguran jumlahnya tidak ditambahkan dengan Surat Peringatan,tetapi diambil dari pemotongan yang terbesar.</td>
          <td class="column11 style7 null"></td>
          <td class="column12">&nbsp;</td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row47">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style47 s style47" style="padding-left: 5px;" colspan="10">* SPV – MM : Supervisor - Manager Madya yang mempunyai anak buah/staf</td>
          <td class="column11 style7 null"></td>
          <td class="column12">&nbsp;</td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row48">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style47 s style47" style="padding-left: 5px;" colspan="10">** SPV – MM : Supervisor - Manager Madya yang tidak mempunyai anak buah/staf</td>
          <td class="column11 style7 null"></td>
          <td class="column12">&nbsp;</td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row49">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style47 s style47" style="padding-left: 5px;" colspan="10">*** Penilaian harus angka bulat, tidak berlaku nilai dibelakang koma</td>
          <td class="column11 style7 null"></td>
          <td class="column12">&nbsp;</td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row50">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style47 s style47" style="padding-left: 5px;" colspan="10">**** Beri lingkaran sesuai kategori PA masing-masing karyawan</td>
          <td class="column11 style7 null"></td>
          <td class="column12">&nbsp;</td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
        <tr class="row51">
          <td class="column0">&nbsp;</td>
          <td class="column1page1 style47 s style47" style="padding-left: 5px;" colspan="10">***** Wajib di isi</td>
          <td class="column11 style7 null"></td>
          <td class="column12">&nbsp;</td>
          <td class="column13 style2 null"></td>
          <td class="column14 style2 null"></td>
          <td class="column15 style2 null"></td>
          <td class="column16 style2 null"></td>
          <td class="column17 style2 null"></td>
          <td class="column18 style2 null"></td>
        </tr>
      </tbody>
    </table>

    <div class="pagebreak"></div>

    <table border="0" cellpadding="0" cellspacing="0" id="sheet0page2" class="sheet0page2" width="100%">
      <tbody>
        <tr class="row1">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style59page2 s style59page2" colspan="5">Form Performance Appraisal</td>
          <td class="column9 style7page2 null" colspan="2" rowspan="2" style="text-align: right; padding-right: 5px;">
            <img src="{{ asset('images\metland_logo_transparant.png') }}">
          </td>
        </tr>
        <tr class="row2">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style60page2 s style60page2" colspan="7">PT. Metropolitan Land Tbk</td>
          <td class="column9 style8page2 null"></td>
          <td class="column10 style8page2 null"></td>
          <td class="column11 style8page2 null"></td>
        </tr>
        <tr class="row3">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style60page2 null style60page2" colspan="7"></td>
          <td class="column9 style8page2 null"></td>
          <td class="column10 style8page2 null"></td>
          <td class="column11 style8page2 null"></td>
        </tr>
        <tr class="row4">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          @if($appraisal_code == "PA1")
          <td class="column2 style6page2 s" colspan="5">Lembar Penilaian Posisi: Staff</td>
          @elseif($appraisal_code == "PA2")
          <td class="column2 style6page2 s" colspan="5">Lembar Penilaian Posisi: Supervisor - Manager Madya (Punya Anak Buah)</td>
          @elseif($appraisal_code == "PA3")
          <td class="column2 style6page2 s" colspan="5">Lembar Penilaian Posisi: Supervisor - Manager Madya (Tanpa Anak Buah)</td>
          @elseif($appraisal_code == "PA4")
          <td class="column2 style6page2 s" colspan="5">Lembar Penilaian Posisi: Sr. Manager - General Manager</td>
          @elseif($appraisal_code == "PA5")
          <td class="column2 style6page2 s" colspan="5">Lembar Penilaian Posisi: Vice Director</td>
          @else
          <td class="column2 style6page2 s" colspan="5">[NOT SET]</td>
          @endif
          <td class="column4 style6page2 null"></td>
          <td class="column5 style6page2 null"></td>
        </tr>
        <tr class="row5">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style64page2 n style64page2" rowspan="2">1</td>
          <td class="column3 style67page2 s style67page2" colspan="3" rowspan="2">Produktivitas (Kontribusi terhadap Perusahaan)</td>
          <td class="column6page2 style51page2 s style51page2" rowspan="2">Pedoman Perilaku (Metland Spirit)</td>
          <td class="column7 style61page2 s style62page2" rowspan="2">Nilai Maksimum</td>
          <td class="column8 style61page2 s style62page2" rowspan="2">Nilai Karyawan</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row6">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <?php $total_nilai_max = 0; $total_nilai_appraisal = 0; $no = "a"; ?>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 1)
                @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                <tr class="row7">
                    <td class="column0">&nbsp;</td>
                    <td class="column1">&nbsp;</td>
                    @if($key2 == 0)
                    <td class="column2 style52page2 null style53page2" rowspan="{{ count($dataAppraisalCategory->dataAppraisals) }}"></td>
                    @endif
                    <td class="column3 style9page2 s">{{ $no }}</td>
                    <td class="column4 style57page2 s style57page2" colspan="2">{{ $dataAppraisal->factor }}</td>
                    <td class="column6page2 style9page2 s">{{ $dataAppraisal->pedoman_metland_spirit }}</td>
                    <td class="column7 style9page2 n">{{ (float) $dataAppraisal->max_value }}</td>
                    <td class="column8 style9page2 null">{{ (float) $dataAppraisal->dataEmpApparaisalValue }}</td>
                    <td class="column9">&nbsp;</td>
                    <td class="column10">&nbsp;</td>
                    <td class="column11">&nbsp;</td>
                </tr>
                <?php $no++; $total_nilai_max += $dataAppraisal->max_value; $total_nilai_appraisal += $dataAppraisal->dataEmpApparaisalValue; ?>
                @endforeach
            @endif
        @endforeach
        <tr class="row10">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style12page2 null"></td>
          <td class="column3 style12page2 null"></td>
          <td class="column4 style13page2 null"></td>
          <td class="column5 style12page2 null"></td>
          <td class="column6page2 style12page2 null"></td>
          <td class="column7 style19page2 f">{{ $total_nilai_max }}</td>
          <td class="column8 style19page2 null">{{ $total_nilai_appraisal }}</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row11">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style12page2 null"></td>
          <td class="column3 style12page2 null"></td>
          <td class="column4 style12page2 null"></td>
          <td class="column5 style12page2 null"></td>
          <td class="column6page2 style12page2 null"></td>
          <td class="column7 style14page2 null"></td>
          <td class="column8 style12page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row12">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style64page2 n style64page2" rowspan="2">2</td>
          <td class="column3 style67page2 s style67page2" colspan="3" rowspan="2">Kompetensi (Kemampuan yang menunjang pekerjaan)</td>
          <td class="column6page2 style51page2 s style51page2" rowspan="2">Pedoman Perilaku (Metland Spirit)</td>
          <td class="column7 style61page2 s style62page2" rowspan="2">Nilai Maksimum</td>
          <td class="column8 style61page2 s style62page2" rowspan="2">Nilai Karyawan</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row13">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <?php $total_nilai_max = 0; $total_nilai_appraisal = 0; $no = "a"; ?>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 2)
                @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                <tr class="row14">
                    <td class="column0">&nbsp;</td>
                    <td class="column1">&nbsp;</td>
                    @if($key2 == 0)
                    <td class="column2 style52page2 null style53page2" rowspan="{{ count($dataAppraisalCategory->dataAppraisals) }}"></td>
                    @endif
                    <td class="column3 style20page2 s">{{ $no }}</td>
                    <td class="column4 style65page2 s style65page2" colspan="2">{{ $dataAppraisal->factor }}</span>
                    </td>
                    <td class="column6page2 style9page2 s">{{ $dataAppraisal->pedoman_metland_spirit }}</td>
                    <td class="column7 style9page2 n">{{ (float) $dataAppraisal->max_value }}</td>
                    <td class="column8 style9page2 null">{{ (float) $dataAppraisal->dataEmpApparaisalValue }}</td>
                    <td class="column9">&nbsp;</td>
                    <td class="column10">&nbsp;</td>
                    <td class="column11">&nbsp;</td>
                </tr>
                <?php $no++; $total_nilai_max += $dataAppraisal->max_value; $total_nilai_appraisal += $dataAppraisal->dataEmpApparaisalValue; ?>
                @endforeach
            @endif
        @endforeach
        <tr class="row17">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style12page2 null"></td>
          <td class="column3 style12page2 null"></td>
          <td class="column4 style13page2 null"></td>
          <td class="column5 style12page2 null"></td>
          <td class="column6page2 style12page2 null"></td>
          <td class="column7 style19page2 f">{{ $total_nilai_max }}</td>
          <td class="column8 style19page2 null">{{ $total_nilai_appraisal }}</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row18">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style12page2 null"></td>
          <td class="column3 style12page2 null"></td>
          <td class="column4 style12page2 null"></td>
          <td class="column5 style12page2 null"></td>
          <td class="column6page2 style12page2 null"></td>
          <td class="column7 style14page2 null"></td>
          <td class="column8 style12page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row19">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style64page2 n style64page2" rowspan="2">3</td>
          <td class="column3 style67page2 s style67page2" colspan="3" rowspan="2">Karakter</td>
          <td class="column6page2 style51page2 s style51page2" rowspan="2">Pedoman Perilaku (Metland Spirit)</td>
          <td class="column7 style61page2 s style62page2" rowspan="2">Nilai Maksimum</td>
          <td class="column8 style61page2 s style62page2" rowspan="2">Nilai Karyawan</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row20">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row21">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style25page2 s">3.1</td>
          <td class="column3 style54page2 s style56page2" colspan="6">Disiplin (Kepatuhan)</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <?php
          $countRowAppraisal = 0;
          foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory) {
            if($dataAppraisalCategory->id == 3) {
              foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal) {
                if($dataAppraisal->sub_appraisal == "Disiplin (Kepatuhan)") {
                  $countRowAppraisal++;
                }
              }
            }
          }
        ?>
        <?php $total_nilai_max = 0; $total_nilai_appraisal = 0; $no = "a"; ?>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 3)
                <?php $key3 = 0; ?>
                @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                    @if($dataAppraisal->sub_appraisal == "Disiplin (Kepatuhan)")
                        <tr class="row22">
                            <td class="column0">&nbsp;</td>
                            <td class="column1">&nbsp;</td>
                            @if($key3 == 0)
                            <td class="column2 style52page2 null style53page2" rowspan="{{ $countRowAppraisal }}"></td>
                            @endif
                            <td class="column3 style9page2 s">{{ $no }}</td>
                            <td class="column4 style48page2 s style50page2" colspan="2">{{ $dataAppraisal->factor }}</td>
                            <td class="column6page2 style9page2 s">{{ $dataAppraisal->pedoman_metland_spirit }}</td>
                            <td class="column7 style9page2 n">{{ (float) $dataAppraisal->max_value }}</td>
                            <td class="column8 style9page2 null">{{ (float) $dataAppraisal->dataEmpApparaisalValue }}</td>
                            <td class="column9">&nbsp;</td>
                            <td class="column10">&nbsp;</td>
                            <td class="column11">&nbsp;</td>
                        </tr>
                        <?php $key3++; $no++; $total_nilai_max += $dataAppraisal->max_value; $total_nilai_appraisal += $dataAppraisal->dataEmpApparaisalValue; ?>
                    @endif
                @endforeach
            @endif
        @endforeach
        <tr class="row24">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style23page2 s">3.2</td>
          <td class="column3 style54page2 s style56page2" colspan="6">Behaviour (Sikap)</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <?php
          $countRowAppraisal = 0;
          foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory) {
            if($dataAppraisalCategory->id == 3) {
              foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal) {
                if($dataAppraisal->sub_appraisal == "Behaviour (Sikap)") {
                  $countRowAppraisal++;
                }
              }
            }
          }
        ?>
        <?php $no = "a"; ?>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 3)
                <?php $key3 = 0; ?>
                @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                    @if($dataAppraisal->sub_appraisal == "Behaviour (Sikap)")
                        <tr class="row25">
                            <td class="column0">&nbsp;</td>
                            <td class="column1">&nbsp;</td>
                            @if($key3 == 0)
                            <td class="column2 style66page2 null style53page2" rowspan="{{ $countRowAppraisal }}"></td>
                            @endif
                            <td class="column3 style15page2 s">{{ $no }}</td>
                            <td class="column4 style48page2 s style50page2" colspan="2">{{ $dataAppraisal->factor }}</td>
                            <td class="column6page2 style15page2 s">{{ $dataAppraisal->pedoman_metland_spirit }}</td>
                            <td class="column7 style15page2 n">{{ (float) $dataAppraisal->max_value }}</td>
                            <td class="column8 style15page2 null">{{ (float) $dataAppraisal->dataEmpApparaisalValue }}</td>
                            <td class="column9">&nbsp;</td>
                            <td class="column10">&nbsp;</td>
                            <td class="column11">&nbsp;</td>
                        </tr>
                        <?php $key3++; $no++; $total_nilai_max += $dataAppraisal->max_value; $total_nilai_appraisal += $dataAppraisal->dataEmpApparaisalValue; ?>
                    @endif
                @endforeach
            @endif
        @endforeach
        <tr class="row30">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style12page2 null"></td>
          <td class="column3 style12page2 null"></td>
          <td class="column4 style12page2 null"></td>
          <td class="column5 style12page2 null"></td>
          <td class="column6page2 style12page2 null"></td>
          <td class="column7 style19page2 f">{{ $total_nilai_max }}</td>
          <td class="column8 style19page2 null">{{ $total_nilai_appraisal }}</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row31">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style12page2 null"></td>
          <td class="column3 style12page2 null"></td>
          <td class="column4 style13page2 null"></td>
          <td class="column5 style13page2 null"></td>
          <td class="column6page2 style13page2 null"></td>
          <td class="column7 style14page2 null"></td>
          <td class="column8 style12page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 4)
                @if($dataAppraisalCategory->countAppraisal > 0)
                    <tr class="row12">
                    <td class="column0">&nbsp;</td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2 style64page2 n style64page2" rowspan="2">4</td>
                    <td class="column3 style67page2 s style67page2" colspan="3" rowspan="2">Leadership (Kepemimpinan)</td>
                    <td class="column6page2 style51page2 s style51page2" rowspan="2">Pedoman Perilaku (Metland Spirit)</td>
                    <td class="column7 style61page2 s style62page2" rowspan="2">Nilai Maksimum</td>
                    <td class="column8 style61page2 s style62page2" rowspan="2">Nilai Karyawan</td>
                    <td class="column9">&nbsp;</td>
                    <td class="column10">&nbsp;</td>
                    <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row13">
                    <td class="column0">&nbsp;</td>
                    <td class="column1">&nbsp;</td>
                    <td class="column9">&nbsp;</td>
                    <td class="column10">&nbsp;</td>
                    <td class="column11">&nbsp;</td>
                    </tr>
                    <?php $total_nilai_max = 0; $total_nilai_appraisal = 0; $no = "a"; ?>
                    @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
                        @if($dataAppraisalCategory->id == 4)
                            @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                            <tr class="row14">
                                <td class="column0">&nbsp;</td>
                                <td class="column1">&nbsp;</td>
                                @if($key2 == 0)
                                <td class="column2 style52page2 null style53page2" rowspan="{{ count($dataAppraisalCategory->dataAppraisals) }}"></td>
                                @endif
                                <td class="column3 style20page2 s">{{ $no }}</td>
                                <td class="column4 style65page2 s style65page2" colspan="2">{{ $dataAppraisal->factor }}</span>
                                </td>
                                <td class="column6page2 style9page2 s">{{ $dataAppraisal->pedoman_metland_spirit }}</td>
                                <td class="column7 style9page2 n">{{ (float) $dataAppraisal->max_value }}</td>
                                <td class="column8 style9page2 null">{{ (float) $dataAppraisal->dataEmpApparaisalValue }}</td>
                                <td class="column9">&nbsp;</td>
                                <td class="column10">&nbsp;</td>
                                <td class="column11">&nbsp;</td>
                            </tr>
                            <?php $no++; $total_nilai_max += $dataAppraisal->max_value; $total_nilai_appraisal += $dataAppraisal->dataEmpApparaisalValue; ?>
                            @endforeach
                        @endif
                    @endforeach
                    <tr class="row17">
                    <td class="column0">&nbsp;</td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2 style12page2 null"></td>
                    <td class="column3 style12page2 null"></td>
                    <td class="column4 style13page2 null"></td>
                    <td class="column5 style12page2 null"></td>
                    <td class="column6page2 style12page2 null"></td>
                    <td class="column7 style19page2 f">{{ $total_nilai_max }}</td>
                    <td class="column8 style19page2 null">{{ $total_nilai_appraisal }}</td>
                    <td class="column9">&nbsp;</td>
                    <td class="column10">&nbsp;</td>
                    <td class="column11">&nbsp;</td>
                    </tr>
                @endif
            @endif
        @endforeach
        <tr class="row18">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style12page2 null"></td>
          <td class="column3 style12page2 null"></td>
          <td class="column4 style12page2 null"></td>
          <td class="column5 style12page2 null"></td>
          <td class="column6page2 style12page2 null"></td>
          <td class="column7 style14page2 null"></td>
          <td class="column8 style12page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row32">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style47page2 s style47page2" colspan="4">Keterangan Singkatan</td>
          <td class="column6page2 style26page2 null"></td>
          <td class="column7 style26page2 null"></td>
          <td class="column8 style12page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row33">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style48page2 s style50page2" colspan="3">I : Integritas</td>
          <td class="column5 style11page2 s">KK : Kerja Keras</td>
          <td class="column6page2 style26page2 null"></td>
          <td class="column7 style26page2 null"></td>
          <td class="column8 style12page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row34">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style48page2 s style50page2" colspan="3">S : Semangat</td>
          <td class="column5 style11page2 s">E : Entrepreneur</td>
          <td class="column6page2 style26page2 null"></td>
          <td class="column7 style14page2 null"></td>
          <td class="column8 style14page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row35">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style48page2 s style50page2" colspan="3">P : Profesional</td>
          <td class="column5 style11page2 s">PM : Pantang Menyerah</td>
          <td class="column6page2 style26page2 null"></td>
          <td class="column7 style17page2 null"></td>
          <td class="column8 style12page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row36">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style13page2 null"></td>
          <td class="column3 style13page2 null"></td>
          <td class="column4 style13page2 null"></td>
          <td class="column5 style13page2 null"></td>
          <td class="column6page2 style13page2 null"></td>
          <td class="column7 style18page2 null"></td>
          <td class="column8 style13page2 null"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row37">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style27page2 s style27page2" colspan="7">Tanggal Penilaian: {{ $dataTglPenilaian }}</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row38">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style28page2 s style28page2" colspan="3">Dinilai Oleh,</td>
          <td class="column5 style24page2 s">Atasan Penilai,</td>
          <td class="column6page2 style41page2 s style43page2" colspan="3">Disetujui Oleh,</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row39">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style29page2 null style37page2" colspan="3" rowspan="3"></td>
          <td class="column5 style44page2 null style46page2" rowspan="3"></td>
          <td class="column6page2 style29page2 null style37page2" colspan="3" rowspan="3"></td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row40">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row41">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
        <tr class="row42">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2 style38page2 s style40page2" colspan="3">{{ ucwords(strtolower($emp_evaluator->emp_firstname.' '.$emp_evaluator->emp_middle_name.' '.$emp_evaluator->emp_lastname)) }}</td>
          <td class="column5 style11page2 s style40page2">{{ ucwords(strtolower($report_to_emp_evaluator_lvl2->emp_firstname.' '.$report_to_emp_evaluator_lvl2->emp_middle_name.' '.$report_to_emp_evaluator_lvl2->emp_lastname)) }}</td>
          <td class="column6page2 style38page2 s style40page2" colspan="3">{{ ucwords(strtolower($report_to_emp_evaluator_lvl3->emp_firstname.' '.$report_to_emp_evaluator_lvl3->emp_middle_name.' '.$report_to_emp_evaluator_lvl3->emp_lastname)) }}</td>
          <td class="column9">&nbsp;</td>
          <td class="column10">&nbsp;</td>
          <td class="column11">&nbsp;</td>
        </tr>
      </tbody>
    </table>

    <div class="pagebreak"></div>

    <table border="0" cellpadding="0" cellspacing="0" id="sheet0page3" class="sheet0page3" width="100%">
      <tbody>
        <tr class="row1">
          <td class="column1 style6page3 s" colspan="5" style="text-align: left;">KRITERIA PENILAIAN KARYAWAN</td>
          <td class="column1 style6page3 s" style="text-align: right;" width="1%">
            <img src="{{ asset('images\metland_logo_transparant.png') }}">
          </td>
        </tr>
        <tr class="row2">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2">&nbsp;</td>
          <td class="column3 style5page3 null"></td>
          <td class="column4 style5page3 null"></td>
          <td class="column5">&nbsp;</td>
          <td class="column6">&nbsp;</td>
        </tr>
        <?php
            $max_val_prod = 0;
            $max_val_kompetensi = 0;
            $max_val_karakter = 0;
            $max_val_leadership = 0;
            foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory) {
                if($dataAppraisalCategory->id == 1) {
                    foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal) {
                        $max_val_prod += $dataAppraisal->max_value;
                    }
                }
                if($dataAppraisalCategory->id == 2) {
                    foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal) {
                        $max_val_kompetensi += $dataAppraisal->max_value;
                    }
                }
                if($dataAppraisalCategory->id == 3) {
                    foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal) {
                        $max_val_karakter += $dataAppraisal->max_value;
                    }
                }
                if($dataAppraisalCategory->id == 4) {
                    foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal) {
                        $max_val_leadership += $dataAppraisal->max_value;
                    }
                }
            }
        ?>
        <tr class="row3">
          <td class="column0 style15page3 s" colspan="3">Total Nilai Productivity: {{ $max_val_prod }}</td>
          <td class="column1 style3page3 null"></td>
          <td class="column2">&nbsp;</td>
          <td class="column3">&nbsp;</td>
          <td class="column4">&nbsp;</td>
        </tr>
        <tr class="row4">
          <td class="column0 style30page3 s style31page3" rowspan="2">No</td>
          <td class="column1 style28page3 s style29page3" rowspan="2">Faktor yang Dinilai</td>
          <td class="column2 style25page3 s style25page3" colspan="4">Tolok ukur</td>
          <td class="column6">&nbsp;</td>
        </tr>
        <?php $no = 1; ?>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 1)
                @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                    <?php $tolak_ukur = explode(",", $dataAppraisal->tolak_ukur); ?>
                    @if($key2 == 0)
                    <tr class="row5">
                        <td class="column2 style8page3 s">{{ $tolak_ukur[0] }}</td>
                        <td class="column3 style8page3 s">{{ $tolak_ukur[1] }}</td>
                        <td class="column4 style8page3 s">{{ $tolak_ukur[2] }}</td>
                        <td class="column5 style8page3 n">{{ $tolak_ukur[3] }}</td>
                        <td class="column6">&nbsp;</td>
                    </tr>
                    <tr class="row6">
                        <td class="column0 style9page3 n">{{ $no }}</td>
                        <td class="column1 style10page3 s">{{ $dataAppraisal->factor }}</td>
                        <td class="column2 style11page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                        <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                        <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                        <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    @else
                    <tr class="row7">
                        <td class="column0 style26page3 n style26page3" rowspan="2">{{ $no }}</td>
                        <td class="column1 style27page3 s style27page3" rowspan="2">{{ $dataAppraisal->factor }}</td>
                        <td class="column2 style8page3 s">{{ $tolak_ukur[0] }}</td>
                        <td class="column3 style8page3 s">{{ $tolak_ukur[1] }}</td>
                        <td class="column4 style8page3 s">{{ $tolak_ukur[2] }}</td>
                        <td class="column5 style8page3 n">{{ $tolak_ukur[3] }}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    <tr class="row8">
                        <td class="column2 style13page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                        <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                        <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                        <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    @endif
                    <?php $no++; ?>
                @endforeach
            @endif
        @endforeach
      </tbody>
    </table>

    <div class="pagebreak"></div>

    <table border="0" cellpadding="0" cellspacing="0" id="sheet0page3" class="sheet0page3" width="100%">
      <tbody>
        <tr class="row1">
          <td class="column1 style6page3 s" colspan="5" style="text-align: left;">KRITERIA PENILAIAN KARYAWAN</td>
          <td class="column1 style6page3 s" style="text-align: right;" width="1%">
            <img src="{{ asset('images\metland_logo_transparant.png') }}">
          </td>
        </tr>
        <tr class="row2">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2">&nbsp;</td>
          <td class="column3 style5page3 null"></td>
          <td class="column4 style5page3 null"></td>
          <td class="column5">&nbsp;</td>
          <td class="column6">&nbsp;</td>
        </tr>
        <tr class="row3">
          <td class="column0 style15page3 s" colspan="3">Total Nilai Competency: {{ $max_val_kompetensi }}</td>
          <td class="column1 style3page3 null"></td>
          <td class="column2">&nbsp;</td>
          <td class="column3">&nbsp;</td>
          <td class="column4">&nbsp;</td>
        </tr>
        <tr class="row4">
          <td class="column0 style30page3 s style31page3" rowspan="2">No</td>
          <td class="column1 style28page3 s style29page3" rowspan="2">Faktor yang Dinilai</td>
          <td class="column2 style25page3 s style25page3" colspan="4">Tolok ukur</td>
          <td class="column6">&nbsp;</td>
        </tr>
        <?php $no = 1; ?>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 2)
                @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                    <?php $tolak_ukur = explode(",", $dataAppraisal->tolak_ukur); ?>
                    @if($key2 == 0)
                    <tr class="row5">
                        <td class="column2 style8page3 s">{{ $tolak_ukur[0] }}</td>
                        <td class="column3 style8page3 s">{{ $tolak_ukur[1] }}</td>
                        <td class="column4 style8page3 s">{{ $tolak_ukur[2] }}</td>
                        <td class="column5 style8page3 n">{{ $tolak_ukur[3] }}</td>
                        <td class="column6">&nbsp;</td>
                    </tr>
                    <tr class="row6">
                        <td class="column0 style9page3 n">{{ $no }}</td>
                        <td class="column1 style10page3 s">{{ $dataAppraisal->factor }}</td>
                        <td class="column2 style11page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                        <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                        <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                        <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    @else
                    <tr class="row7">
                        <td class="column0 style26page3 n style26page3" rowspan="2">{{ $no }}</td>
                        <td class="column1 style27page3 s style27page3" rowspan="2">{{ $dataAppraisal->factor }}</td>
                        <td class="column2 style8page3 s">{{ $tolak_ukur[0] }}</td>
                        <td class="column3 style8page3 s">{{ $tolak_ukur[1] }}</td>
                        <td class="column4 style8page3 s">{{ $tolak_ukur[2] }}</td>
                        <td class="column5 style8page3 n">{{ $tolak_ukur[3] }}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    <tr class="row8">
                        <td class="column2 style13page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                        <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                        <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                        <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    @endif
                    <?php $no++; ?>
                @endforeach
            @endif
        @endforeach
      </tbody>
    </table>

    <div class="pagebreak"></div>

    <table border="0" cellpadding="0" cellspacing="0" id="sheet0page3" class="sheet0page3" width="100%">
      <tbody>
        <tr class="row1">
          <td class="column1 style6page3 s" colspan="5" style="text-align: left;">KRITERIA PENILAIAN KARYAWAN</td>
          <td class="column1 style6page3 s" style="text-align: right;" width="1%">
            <img src="{{ asset('images\metland_logo_transparant.png') }}">
          </td>
        </tr>
        <tr class="row2">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2">&nbsp;</td>
          <td class="column3 style5page3 null"></td>
          <td class="column4 style5page3 null"></td>
          <td class="column5">&nbsp;</td>
          <td class="column6">&nbsp;</td>
        </tr>
        <tr class="row3">
          <td class="column0 style15page3 s" colspan="3">Total Nilai Character: {{ $max_val_karakter }}</td>
          <td class="column1 style3page3 null"></td>
          <td class="column2">&nbsp;</td>
          <td class="column3">&nbsp;</td>
          <td class="column4">&nbsp;</td>
        </tr>
        <tr class="row4">
          <td class="column0 style30page3 s style31page3">No</td>
          <td class="column1 style28page3 s style29page3">Faktor yang Dinilai</td>
          <td class="column2 style25page3 s style25page3" colspan="4">Tolok ukur</td>
          <td class="column6">&nbsp;</td>
        </tr>
        <?php $no = 1; ?>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 3)
                <?php $no2 = "3.1"; ?>
                @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                    <?php $tolak_ukur = explode(",", $dataAppraisal->tolak_ukur); ?>
                    @if($key2 == 0)
                    <tr class="row5">
                        <td class="column1 style8page3 s">{{ $no2 }}</td>
                        <td class="column2 style8page3 s">{{ $dataAppraisal->sub_appraisal }}</td>
                        <td class="column2 style8page3 s">{{ $tolak_ukur[0] }}</td>
                        <td class="column3 style8page3 s">{{ $tolak_ukur[1] }}</td>
                        <td class="column4 style8page3 s">{{ $tolak_ukur[2] }}</td>
                        <td class="column5 style8page3 n">{{ $tolak_ukur[3] }}</td>
                        <td class="column6">&nbsp;</td>
                    </tr>
                    <tr class="row6">
                        <td class="column0 style9page3 n">{{ $no }}</td>
                        <td class="column1 style10page3 s">{{ $dataAppraisal->factor }}</td>
                        <td class="column2 style11page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                        <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                        <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                        <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    <?php $no2 += 0.1; ?>
                    @else
                      @if($dataAppraisal->sub_appraisal <> $dataAppraisalCategory->dataAppraisals[$key2 - 1]->sub_appraisal)
                        <tr class="row5">
                          <td class="column1 style8page3 s">{{ $no2 }}</td>
                          <td class="column2 style8page3 s">{{ $dataAppraisal->sub_appraisal }}</td>
                          <td class="column2 style8page3 s">{{ $tolak_ukur[0] }}</td>
                          <td class="column3 style8page3 s">{{ $tolak_ukur[1] }}</td>
                          <td class="column4 style8page3 s">{{ $tolak_ukur[2] }}</td>
                          <td class="column5 style8page3 n">{{ $tolak_ukur[3] }}</td>
                          <td class="column6">&nbsp;</td>
                        </tr>
                        <tr class="row6">
                          <td class="column0 style9page3 n">{{ $no }}</td>
                          <td class="column1 style10page3 s">{{ $dataAppraisal->factor }}</td>
                          <td class="column2 style11page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                          <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                          <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                          <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                          <td class="column6 style4page3 null"></td>
                        </tr>
                        <?php $no2 += 0.1; ?>
                      @else
                        <tr class="row7">
                          <td class="column1 style9page3 s" rowspan="2">{{ $no }}</td>
                          <td class="column2 style10page3 s" rowspan="2">{{ $dataAppraisal->factor }}</td>
                          <td class="column3 style8page3 s">{{ $tolak_ukur[0] }}</td>
                          <td class="column4 style8page3 s">{{ $tolak_ukur[1] }}</td>
                          <td class="column5 style8page3 s">{{ $tolak_ukur[2] }}</td>
                          <td class="column6 style8page3 n">{{ $tolak_ukur[3] }}</td>
                          <td class="column7 style4page3 null"></td>
                        </tr>
                        <tr class="row8">
                          <td class="column2 style13page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                          <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                          <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                          <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                          <td class="column6 style4page3 null"></td>
                        </tr>
                      @endif
                    @endif
                    <?php $no++; ?>
                @endforeach
            @endif
        @endforeach
      </tbody>
    </table>

    @if($max_val_leadership > 0)
    <div class="pagebreak"></div>

    <table border="0" cellpadding="0" cellspacing="0" id="sheet0page3" class="sheet0page3" width="100%">
      <tbody>
        <tr class="row1">
          <td class="column1 style6page3 s" colspan="5" style="text-align: left;">KRITERIA PENILAIAN KARYAWAN</td>
          <td class="column1 style6page3 s" style="text-align: right;" width="1%">
            <img src="{{ asset('images\metland_logo_transparant.png') }}">
          </td>
        </tr>
        <tr class="row2">
          <td class="column0">&nbsp;</td>
          <td class="column1">&nbsp;</td>
          <td class="column2">&nbsp;</td>
          <td class="column3 style5page3 null"></td>
          <td class="column4 style5page3 null"></td>
          <td class="column5">&nbsp;</td>
          <td class="column6">&nbsp;</td>
        </tr>
        <tr class="row3">
          <td class="column0 style15page3 s" colspan="3">Total Nilai Leadership: {{ $max_val_leadership }}</td>
          <td class="column1 style3page3 null"></td>
          <td class="column2">&nbsp;</td>
          <td class="column3">&nbsp;</td>
          <td class="column4">&nbsp;</td>
        </tr>
        <tr class="row4">
          <td class="column0 style30page3 s style31page3" rowspan="2">No</td>
          <td class="column1 style28page3 s style29page3" rowspan="2">Faktor yang Dinilai</td>
          <td class="column2 style25page3 s style25page3" colspan="4">Tolok ukur</td>
          <td class="column6">&nbsp;</td>
        </tr>
        <?php $no = 1; ?>
        @foreach($dataAppraisalCategorys as $key => $dataAppraisalCategory)
            @if($dataAppraisalCategory->id == 4)
                @foreach($dataAppraisalCategory->dataAppraisals as $key2 => $dataAppraisal)
                    <?php $tolak_ukur = explode(",", $dataAppraisal->tolak_ukur); ?>
                    @if($key2 == 0)
                    <tr class="row5">
                        <td class="column2 style8page3 s">{{ $tolak_ukur[0] }}</td>
                        <td class="column3 style8page3 s">{{ $tolak_ukur[1] }}</td>
                        <td class="column4 style8page3 s">{{ $tolak_ukur[2] }}</td>
                        <td class="column5 style8page3 n">{{ $tolak_ukur[3] }}</td>
                        <td class="column6">&nbsp;</td>
                    </tr>
                    <tr class="row6">
                        <td class="column0 style9page3 n">{{ $no }}</td>
                        <td class="column1 style10page3 s">{{ $dataAppraisal->factor }}</td>
                        <td class="column2 style11page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                        <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                        <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                        <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    @else
                    <tr class="row7">
                        <td class="column0 style26page3 n style26page3" rowspan="2">{{ $no }}</td>
                        <td class="column1 style27page3 s style27page3" rowspan="2">{{ $dataAppraisal->factor }}</td>
                        <td class="column2 style8page3 s">{{ $tolak_ukur[0] }}</td>
                        <td class="column3 style8page3 s">{{ $tolak_ukur[1] }}</td>
                        <td class="column4 style8page3 s">{{ $tolak_ukur[2] }}</td>
                        <td class="column5 style8page3 n">{{ $tolak_ukur[3] }}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    <tr class="row8">
                        <td class="column2 style13page3 s">{!! $dataAppraisal->tips_kurang !!}</td>
                        <td class="column3 style12page3 s">{!! $dataAppraisal->tips_cukup !!}</td>
                        <td class="column4 style12page3 s">{!! $dataAppraisal->tips_baik !!}</td>
                        <td class="column5 style12page3 s">{!! $dataAppraisal->tips_sb !!}</td>
                        <td class="column6 style4page3 null"></td>
                    </tr>
                    @endif
                    <?php $no++; ?>
                @endforeach
            @endif
        @endforeach
      </tbody>
    </table>
    @endif
  </body>
</html>
