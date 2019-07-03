<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <!--<link rel="stylesheet"-->
    <!--href="https://fonts.googleapis.com/css?family=Prompt:400,400i,500,500i,600,600i,700,700i,900,900i"/>-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link rel="icon" href="<?php echo base_url('img/tcrbank.ico'); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('js/build/referral_script/crop_img/fab-button.css'); ?>"/>
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #e5e5e5;
        }

        .clear {
            clear: both;
            line-height: 0;
            height: 0;
        }

        .header {
            -webkit-print-color-adjust: exact;
            background-color: #00609c;
            width: 100%;
            left: 0;
            top: 0;
            height: 70px;
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
        }

        .logo-header {
            margin: 5px;
            margin-left: 15px;
            height: 60px;
        }

        .container {
            position: relative;
            margin: 15px auto;
            width: 745px;
            height: 1020px;
            box-shadow: rgba(0, 0, 0, 0.44) 0px 1px 6px, rgba(0, 0, 0, 0.13) 0px 1px 4px;
            border-radius: 2px;
            background-color: #FFF;
        }

        .paper-header {
            background-color: #607D8B;
            width: 100%;
            height: 300px;
            position: fixed;
            top: 0;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 6px, rgba(0, 0, 0, 0.13) 0px 1px 4px;
        }

        .content {
            padding: 3px;
        }

        .content-header {
            display: block;
            padding: 5px;
            font-size: 13px;
            /*margin-left: 20px;*/
        }

        .content-header > span {
            line-height: 1.7rem;
        }

        .content-header > .title {
            display: block;
            text-align: left;
            font-weight: bold;
        }

        .content-header > .detail {
            display: block;
            text-align: left;
        }

        .content-header.title-date {
            margin-top: 0;
        }

        .content-header.title-date:after {
            content: '.........................................................................................................';
        }

        .row {
            width: 100%;
            display: table;
        }

        .select-image {
            width: 333px;
            height: 220px;
            border: 1px solid #e7e7e7;
            display: table;
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
            border-radius: 3px;
        }

        .select-image:hover, .select-image > span:hover {
            border-color: #bdbdbd;
            color: #2196F3;
        }

        .select-image > span {
            display: table-cell;
            vertical-align: middle;
            font-size: 70px;
            color: #c3c3c3;
            transition: 0.5s;
        }

/*        .group-image {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }*/

        .group-image
        {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            vertical-align: middle;
            margin-bottom: 20px;
            margin-top: 20px;
            font-size: 13px;
        }

        .content-image {
            width: 380px;
            height: 300px;
            overflow: hidden;
            display: table-cell;
            vertical-align: middle;
            padding-left: 7px;
            font-size: 13px;
            line-height: 2rem;
        }

        .content-message {
            display: block;
        }

        .content-signature {
            display: block;
            text-align: center;
            line-height: 2em;
        }

        .bg-img-container {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
            background-color: #EEE;
        }

        .img-container {
            width: 100%;
            height: 545px;
            border: 2px dashed #a3a3a3;
            border-radius: 5px;
            display: table;
            text-align: center;
            box-sizing: border-box;
            transition: .2s all ease-in-out;
        }

        .img-toolbar:hover {
            transition: all 0.6s cubic-bezier(.87, -.41, .19, 1.44)
        }

        .img-toolbar.active {
            opacity: 1;
            transform: scale(1);
        }

        .img-toolbar {
            position: absolute;
            left: 50%;
            bottom: 25px;
            z-index: 2015;
            width: 288px;
            height: 32px;
            margin-left: -128px;
            background-color: #FFF;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            transition: .2s all ease-out;
            opacity: 0;
            transform: scale(2);
        }

        .img-toolbar > button {
            float: left;
            display: block;
            width: 32px;
            height: 32px;
            border-width: 0;
            font-size: 18px;
            text-align: center;
            background-color: transparent;
            color: #595959;
            cursor: pointer;
            transition: .1s ease-out;
        }

        .img-toolbar > button.icon-active {
            color: #2196f3;
        }

        .img-toolbar > button:focus {
            outline: none;
        }

        .img-toolbar > button:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .img-toolbar > button:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .img-toolbar > button.check {
            color: #4CAF50;
        }

        .img-toolbar > button.cancel {
            color: #E91E63;
        }

        .img-toolbar > button:hover {
            background-color: #2196f3;
            color: #fff;
            transform: scale(1.2);
        }

        .img-toolbar > button.check:hover {
            background-color: #4CAF50;
        }

        .img-toolbar > button.cancel:hover {
            background-color: #E91E63;
        }

        .img-container-filedrop, .img-container-filedrop > .label-file-drop > span.fa {
            color: #8BC34A;
            transform: scale(.98, .98);
        }

        [type=file] {
            display: none;
        }

        .img-container-hover {
            border-color: #4a798f;
        }

        .view-container {
            width: 100%;
            height: 545px;
            border-radius: 5px;
            box-sizing: border-box;
            transition: .2s all ease-in-out;
            display: none;
        }

        #result_img {
            max-width: 100%;
        }

        img {
            max-width: 100%;
        }

        .label-file-drop {
            display: table-cell;
            vertical-align: middle;
            color: #7b7b7b;
            cursor: pointer;
        }

        .label-file-drop > span.fa {
            font-size: 7em;
            color: #FF5722;
            transition: .3s all;
        }

        button[disabled]:active, button[disabled],
        input[type="button"][disabled]:active,
        input[type="button"][disabled],
        input[type="submit"][disabled]:active,
        input[type="submit"][disabled],
        button[disabled]:hover,
        input[type="button"][disabled]:hover,
        input[type="submit"][disabled]:hover {
            filter: grayscale(100%);
            background-color: inherit !important;
            color: #a8a8a8 !important;
            cursor: not-allowed;
            transform: scale(1);
        }

        .form-image {
            padding: 3px;
            border: 1px solid black;
            width: 335px;
            height: 220px;
            border-radius: 7px;
        }

        .form-image > img {
            width: 100%;
            height: 100%;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            /*background-color: #fefefe;*/
            margin: auto;
            padding: 0;
            /*border: 1px solid #888;*/
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            /*box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);*/
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }
            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }
            to {
                top: 0;
                opacity: 1
            }
        }

        @keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }
            to {
                top: 0;
                opacity: 1
            }
        }

        /* The Close Button */
        .close {
            float: right;
            color: white;
            font-size: 2em;
            font-weight: bold;
            position: absolute;
            right: 10px;
            top: 13px;
            cursor: pointer;
        }

        .modal-header h2 {
            margin-top: 10px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .modal-header > * {
            display: inline-block;
        }

        .modal-header {
            padding: 2px 16px;
            display: inline-block;
            width: 100%;
            background-color: #2196F3;
            color: white;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
            box-sizing: border-box;
        }

        .modal-body {
            padding: 15px;
            background-color: #FFF;
        }

        .modal-footer {
            padding: 2px 16px;
            background-color: #FFF;
            color: white;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .form-image.water-mark:before {
            content: "เพื่อใช้สมัครเป็นตัวแทนแนะนำสินเชื่อกับ ธ.ไทยเครดิตเพื่อรายย่อย เท่านั้น";
            position: absolute;
            transform: rotate(-30deg);
            font-weight: 500;
            width: 382px;
            margin-top: 85px;
            margin-left: 5px;
            color: black;
            opacity: .5;
            font-size: 20px;
            line-height: 2rem;
            text-align: center;
        }

        .form-image.water-mark.no-watermark:before {
            opacity: 0;
        }

        .p-1 {
            /*margin-top: 10px;*/
        }

        .p-2 {
            /*margin-top: 10px;*/
        }

        .img-cancel {
            position: absolute;
            background-color: #F44336;
            color: #ffffff;
            border-radius: 50%;
            padding: 5px;
            width: 30px;
            height: 30px;
            font-size: 1.8em;
            cursor: pointer;
            margin-top: -19px;
            margin-left: 310px;
            transition: .2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .img-cancel:hover {
            transform: rotate(180deg) scale(.8);
        }

        .hex-btn {
            height: 18.5px;
            width: 32px;
            line-height: 18.5px;
            font-size: 18.5px;
            margin: 9.5px 0;
            display: inline-block;
            position: relative;
            text-align: center;
            z-index: 0;
            background-color: #03A9F4;
            color: white;
            cursor: pointer;
            border-left: 1px solid #03A9F4;
            border-right: 1px solid #03A9F4;
            transition: transform .25s ease;
            box-sizing: border-box;
        }

        .hex-btn > i {
            transform: rotate(-90deg);
        }

        .hex-btn:hover {
            background-color: white;
            color: #03A9F4;
            border-color: #03A9F4;
            transform: rotate(180deg);
        }

        .hex-btn:before {
            content: "";
            background-color: inherit;
            border-left: inherit;
            border-right: inherit;
            width: inherit;
            height: inherit;
            position: absolute;
            content: "";
            left: -1px;
            top: 0;
            z-index: -1;
            box-sizing: border-box;
            transform: rotate(60deg);
        }

        .hex-btn:after {
            content: "";
            background-color: inherit;
            border-left: inherit;
            border-right: inherit;
            width: inherit;
            height: inherit;
            position: absolute;
            content: "";
            left: -1px;
            top: 0;
            z-index: -1;
            box-sizing: border-box;
            transform: rotate(-60deg);
        }

    </style>
    <style media="print">

        @media print {
            body {
                padding: 0 !important;
                margin: 0 !important;
            }

            .img-cancel {
                display: none;
            }

            .no-print {
                display: none !important;
            }

            .not-show {
                opacity: 0;
            }

            .container {
                margin: 0;
                width: 100%;
                box-shadow: none;
            }

            .water-mark {
                display: block;
            }

            .header, .container {
                border-radius: 0;
            }

            .print-form {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
<div class="paper-header not-show print-event"></div>
<div class="container">
    <div class="header not-show print-event">
        <img class="logo-header" src="<?php echo base_url('img/Logo_Bank_Name.jpg'); ?>">
    </div>
    <div class="content">
        <div class="content-header not-show print-event">
            <span class="title">เอกสารประกอบสัญญาจ้างหาลูกค้าและแนะนำผลิตภัณฑ์ทางการเงินสำหรับผู้ประกอบการรายย่อย</span>
            <span class="detail">ฉบับลงวันที่.........................................................................................................................................................................................</span>
            <span class="detail">กิจกรรม........................................................................................................วันที่....................../............................../........................</span>
            <span class="detail">เบอร์โทรติดต่อ......................................................................................................................................................................(ผู้สมัคร)</span>
            <span class="detail">ผู้แนะนำ................................................................................................................เบอร์โทรติดต่อ..............................................(ถ้ามี)</span>
        </div>
        <div class="p-1 row">
            <div class="group-image">
                <span class="not-show print-event">สำเนาบัตรประจำตัวประชาชน</span>

                <div style="flex-grow: 1; display: flex; flex-direction: column; align-items: center; width: 100%;">
                <div class="form-image water-mark no-border" style="display: none;">
                    <span class="fa fa-close img-cancel"></span>
                    <img style="cursor: pointer;" id="result_IDCard"
                         class="open-modal not-show show-when-print"
                         data-result="result_IDCard"
                         data-modal="crop_modal"/>
                </div>
                <div class="form-image no-border">
                    <div class="open-modal select-image not-show print-event" data-result="result_IDCard"
                         data-modal="crop_modal">
                        <span class="fa fa-plus-circle not-show"></span>
                    </div>
                </div>
                </div>
            </div>
<!--            <div class="content-image not-show print-event">
                <span class="content-message">ข้าพเจ้า นาย,นาง,นางสาว..............................................................</span>
                <span class="content-message">เลขประจำตัวประชาชน..................................................................</span>
                <span class="content-message">ขอรับรองว่า ได้ส่งมอบสำเนาบัตรประจำตัวประชาชนให้ไว้</span>
                <span class="content-message">บมจ.ธนาคารไทยเครดิตเพื่อรายย่อย เป็นเอกสารประกอบการว่าจ้าง</span>
                <br/>
                <span class="content-signature">
                    ลงชื่อ (...................................................................) ผู้รับจ้าง
                </span>
            </div>-->
        </div>
        <div class="no-print" style="display: block; text-align: center; width: 100%;">
            <span id="swap-image" class="hex-btn">
                <i class="fa fa-exchange"></i>
            </span>
        </div>
        <div class="p-2 row">
            <div class="group-image">
                <span class="not-show print-event">สำเนาใบอนุญาตเป็นตัวแทนกันชีวิต</span>

                <div style="flex-grow: 1; display: flex; flex-direction: column; align-items: center; width: 100%;">
                <div class="form-image water-mark no-border" style="display: none;">
                    <span class="fa fa-close img-cancel"></span>
                    <img style="cursor: pointer;" id="result_TLACard"
                         class="open-modal not-show show-when-print"
                         data-result="result_TLACard"
                         data-modal="crop_modal"/>
                </div>
                <div class="form-image no-border">
                    <div class="open-modal select-image not-show print-event" data-result="result_TLACard"
                         data-modal="crop_modal">
                        <span class="fa fa-plus-circle not-show"></span>
                    </div>
                </div>
                </div>
            </div>
<!--            <div class="content-image not-show print-event">
                <span class="content-message">ข้าพเจ้า นาย,นาง,นางสาว..............................................................</span>
                <span class="content-message">เลขที่ใบอนุญาต............................................................................</span>
                <span class="content-message">ขอรับรองว่า ได้ส่งมอบสำเนาใบอนุญาตเป็นตัวแทนกันชีวิตให้ไว้</span>
                <span class="content-message">บมจ.ธนาคารไทยเครดิตเพอรายย่อย เป็นเอกสารประกอบการว่าจ้าง</span>
                <br/>
                <span class="content-signature">
                    ลงชื่อ (...................................................................) ผู้รับจ้าง
                </span>
            </div>-->
        </div>
        <div class="p-2 row  not-show print-event" style="line-height: 1.7rem; font-size: 13px; margin-top: 20px;">
            <span style="display: block;">ข้าพเจ้า นาย,นาง,นางสาว..............................................................เลขประจำตัวประชาชน..................................................................</span>
            <span style="display: block;">ขอรับรองว่า ข้าพเจ้าได้ถ่ายสำเนาบัตรประจำตัวประชาชนและหรือสำเนาใบอนุญาตเป็นตัวแทนประกันชีวิตจากต้นฉบับจริง และขอ</span>
            <span style="display: block;">ส่งมอบสำเนาบัตรประจำตัวประชาชนและหรือสำเนาใบอนุญาตเป็นตัวแทนประกันชีวิต ให้กับ บมจ.ธนาคารไทยเครดิต เพื่อรายย่อย</span>
            <span>เพื่อเป็นเอกสารประกอบการว่าจ้าง</span>
        </div>
        <div class="p-2 row  not-show print-event" style="line-height: 1.7rem; font-size: 13px; margin-top: 20px;  text-align: center;">
            <span style="display: block;">ลงชื่อ..............................................................ผู้รับจ้าง</span>
            <span style="display: block;">(.......................................................................)</span>
        </div>
    </div>
    <nav class="menu no-print">
        <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open"/>
        <label class="menu-open-button" for="menu-open">
            <span class="hamburger hamburger-1"></span>
            <span class="hamburger hamburger-2"></span>
            <span class="hamburger hamburger-3"></span>
        </label>

        <a href="#" id="print-form" class="menu-item"> <i class="fa fa-sticky-note"></i> </a>
        <a href="#" id="print-image" class="menu-item"> <i class="fa fa-print"></i> </a>

    </nav>
</div>

<!-- Trigger/Open The Modal -->
<!--<button id="myBtn">Open Modal</button>-->

<script id="crop_modal" type="text/html">

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h2>Select Image</h2>
                <span class="close fa fa-close"></span>
            </div>
            <div class="modal-body">
                <div id="show-img-container" class="bg-img-container">
                    <div id="img-container" class="img-container">
                        <label id="filedrop" class="label-file-drop" for="file-select">
                            <span class="fa fa-cloud-upload"></span>

                            <p style="font-size:2em; margin-bottom: 15px; margin-top: 15px;">Drag & Drop a File</p>

                            <p style="margin: 0;">or click this area for browse your file</p>
                            <input id="file-select" type="file" accept="image/*">
                        </label>
                    </div>
                </div>
                <div>
                    <div class="view-container">
                        <!--<img id="result_img"/>-->
                    </div>
                    <div class="img-toolbar">
                        <button id="select-image" class="icon-active" title="select area">
                            <span class="fa fa-magic"></span>
                        </button>
                        <button id="crop-image" title="crop image">
                            <span class="fa fa-crop"></span>
                        </button>
                        <button id="rotate-left" title="rotate image left">
                            <span class="fa fa-rotate-left"></span>
                        </button>
                        <button id="rotate-right" title="rotate image right">
                            <span class="fa fa-rotate-right"></span>
                        </button>
                        <button id="zoom-in" title="zoom in image">
                            <span class="fa fa-search-plus"></span>
                        </button>
                        <button id="zoom-out" title="zoom out image">
                            <span class="fa fa-search-minus"></span>
                        </button>
                        <button id="undo-image" class="cancel" title="undo image" disabled>
                            <span class="fa fa-undo"></span>
                        </button>
                        <button id="get-image" class="check" title="save image" disabled>
                            <span class="fa fa-check"></span>
                        </button>
                        <button id="delete-image" class="cancel" title="remove image" disabled>
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>

</script>

<script src="<?php echo base_url('js/build/referral_script/crop_img/CropImage.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js"></script>

</body>
</html>