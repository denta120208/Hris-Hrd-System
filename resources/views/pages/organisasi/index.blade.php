@extends('_main_layout')
<script src="{{ URL::asset('js/OrgChart.js') }}"></script>
@section('content')
    <style>
        #tree {
            width: 100%;
            height: 100%;
            background-color: white;
        }
    </style>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="tree"></div>
            <script>
                window.onload = function () {
                    var chart = new OrgChart(document.getElementById("tree"), {
                        layout: OrgChart.mixed,
                        template: "rony",
                        enableDragDrop: false,
                        toolbar: false,
                        nodeMouseClick: OrgChart.action.none,
                        // mouseScrool: OrgChart.action.zoom,
                        tags: {
                            "iAudit": {
                                template: "ula"
                            },
                            residential: {
                                group: true,
                                groupName: "Residential",
                                groupState: OrgChart.EXPAND,
                                template: "group_grey"
                            },
                            manager: {
                                group: true,
                                groupName: "Manager",
                                groupState: OrgChart.EXPAND,
                                template: "group_grey"
                            },
                            spvIT: {
                                group: true,
                                groupName: "Spv",
                                groupState: OrgChart.EXPAND,
                                template: "group_grey"
                            },
                            staffIT: {
                                group: true,
                                groupName: "Staff",
                                groupState: OrgChart.EXPAND,
                                template: "group_grey"
                            }
                        },
                        collapse:{
                            level: 3,
                            allChildren: true
                        },
                        // menu: {
                        //     pdf: { text: "Export PDF" },
                        //     png: { text: "Export PNG" },
                        //     svg: { text: "Export SVG" },
                        //     csv: { text: "Export CSV" }
                        // },
                        // nodeMenu: {
                        //     details: { text: "Details" },
                        //     add: { text: "Add New" },
                        //     edit: { text: "Edit" },
                        //     remove: { text: "Remove" },
                        // },
                        nodeBinding: {
                            field_0: "name",
                            field_1: "title",
                            img_0: "img",
                            // field_number_children: "field_number_children"
                        },
                        nodes: [
                <?php
                    foreach ($org as $row){
                        $emp_name = $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname;
                        $pic = "data:image/jpeg;base64,".base64_encode( $row->epic_picture );
                        echo "{ id: '".$row->id."', pid: ".$row->pid.", spids: [".$row->spid."], tags: ['".$row->tags."'], name: '".$emp_name."', title: '".$row->title."', img: '".$pic."'},";
                    }
                ?>
                        ]
                    });
                };
            </script>
        </div>
    </div>
</div>
@endsection