@extends('_main_layout')
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<link href="{{ URL::asset('css/orgchart_c.css') }}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{ URL::asset('js/orgchart_j.js') }}"></script>
<!--<script src="{{ URL::asset('js/OrgChart.js') }}"></script>-->
@section('content')
    <style type="text/css">
	.navbar-default .navbar-nav > li.clr1 a{
		color:#ffffff;
	}
	.navbar-default .navbar-nav > li.clr2 a{
		color: #FFEB3B;;
	}
	.navbar-default .navbar-nav > li.clr3 a{
		color: #5EC64D;
	}
	.navbar-default .navbar-nav > li.clr4 a{
		color: #29AAE2;
	}
	.navbar-default .navbar-nav > li.clr1 a:hover, .navbar-default .navbar-nav > li.clr1.active a{
		color:#fff;
		background: #F55;
	}
	.navbar-default .navbar-nav > li.clr2 a:hover, .navbar-default .navbar-nav > li.clr2.active a{
		color: #fff;
		background:#973CB6;
	}
	.navbar-default .navbar-nav > li.clr3 a:hover, .navbar-default .navbar-nav > li.clr3.active a{
		color: #fff;
		background:#5EC64D;
	}
	.navbar-default .navbar-nav > li.clr4 a:hover, .navbar-default .navbar-nav > li.clr4.active a{
		color: #fff;
		background: #29AAE2;
	}
	.navbar-default{
		background-color: #3b5998;
		font-size:18px;
	}
	.navbar-default .navbar-brand {
		color: #ffffff;
		font-weight:bold;
	}
	.navbar-default .navbar-text {
		color:#ffffff;
    }
	a{
		color: #FFC107;
		text-decoration: none;
	}
	
	</style>
<div class="navbar navbar-default navbar-fixed-top">
<div class="container">
<div class="row">
<ul id="tree-data" style="display:none">
    <li id="root">
            Direktorat Utama
            <ul>
                    <li id="node1">
                       Direktorat Operasi
                       <ul>
                                    <li id="node6">
                                    Divisi Layanan
                                    </li>
                                    <li id="node6">
                                    Divisi Kepersetaan
                                    <ul>
                                            <li id="node6">
                                            Divisi Administrasi
                                            </li>
                                            <li id="node6">
                                            Divisi Sosialisasi
                                            </li>
                                    </ul>
                                    </li>
                                    <li id="node6">
                                    Divisi Aktuaria
                                    </li>
                            </ul>
                    </li>
                    <li id="node2">
                            Direktorat Investasi
                            <ul>
                                    <li id="node6">
                                    Divisi Investasi
                                    Pasar Uang
                                    </li>
                                    <li id="node6">
                                    Divisi Investasi
                                    Pasar Modal
                                    </li>
                                    <li id="node6">
                                    Analisis Investasi
                                    </li>
                            </ul>
                    </li>
                    <li id="node3">
                       Direktorat Umum

                    </li>
                    <li id="node4">
                       Direktorat Keuangan

                    </li>
                    <li id="node5">
                       Direktorat Informasi
                    </li>
            </ul>

    </li>
</ul>
<div id="tree-view"></div>	
<script>
	$(document).ready(function () {
	// create a tree
	$("#tree-data").jOrgChart({
		chartElement: $("#tree-view"), 
		nodeClicked: nodeClicked
	});
	// lighting a node in the selection
	function nodeClicked(node, type) {
		node = node || $(this);
		$('.jOrgChart .selected').removeClass('selected');
			node.addClass('selected');
		}
	});
</script>		
		
</div>
</div>
</div>
@endsection