(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["voucher_setting"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/canvas.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/canvas.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      justifier: "left",
      fontSize: 0,
      scaleX: 0,
      scaleY: 0,
      leftPos: 0,
      topPos: 0,
      width: 0,
      height: 0,
      lineHeight: 0,
      obj_setting: 0,
      all_buyer: [],
      selected_buyer: [],
      canvasAllData: [],
      canvas: null,
      bg_image_path: null,
      canvas_name: null,
      canvas_id: null,
      update_image_info: null,
      submit_button: 'Save',
      canvas_width: 1219,
      canvas_height: 510,
      pointerX: 100,
      pointerY: 50,
      copiedObjects: [],
      copiedObject: [],
      backgroundModalShow: false,
      modal_image: null,
      tmp_modal_image: null,
      tmp_update_image_info: null,
      activeObjects: []
    };
  },
  methods: {
    backgroundModalFunc: function backgroundModalFunc() {
      this.backgroundModalShow = true;
      this.modal_image = this.bg_image_path;
      this.tmp_modal_image = this.bg_image_path;
      this.tmp_update_image_info = this.update_image_info;
    },
    loadImage: function loadImage($event) {
      var _this2 = this;

      var input = event.target; // Ensure that you have a file before attempting to read it

      if (input.files && input.files[0]) {
        // create a new FileReader to read this image and convert to base64 format
        var reader = new FileReader(); // Define a callback function to run, when FileReader finishes its job

        reader.onload = function (e) {
          // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
          // Read image as base64 and set to imageData
          _this2.modal_image = e.target.result;
        }; // Start the reader job - read file as a data url (base64 format)


        reader.readAsDataURL(input.files[0]);
      }
    },
    change: function change(_ref) {
      var coordinates = _ref.coordinates,
          canvas = _ref.canvas;
      this.backgroundImageSet(canvas.toDataURL());
      this.update_image_info = 1;
    },
    cancelImage: function cancelImage() {
      this.backgroundModalShow = false;
      this.backgroundImageSet(this.tmp_modal_image);
      this.update_image_info = this.tmp_update_image_info;
    },
    loadCanvasData: function loadCanvasData() {
      var _this3 = this;

      axios.post(this.BASE_URL + "api/load_canvas_setting_data").then(function (_ref2) {
        var data = _ref2.data;
        _this3.canvasAllData = data.canvas_info;
        _this3.all_buyer = data.all_buyer; // this.loader.hide();
        // Vue.$loading.hide()
      })["catch"](function () {
        _this3.sweet_advance_alert();
      });
    },
    editCanvas: function editCanvas(canvasData) {
      this.selected_buyer = {
        byr_buyer_id: canvasData.byr_buyer_id,
        company_name: canvasData.company_name
      }; // this.canvas.clear();

      this.canvasClear();
      this.canvas_name = canvasData.canvas_name;
      this.canvas_id = canvasData.cmn_pdf_canvas_id;
      this.submit_button = 'Update';
      this.bg_image_path = this.BASE_URL + 'storage/app/public/backend/images/canvas/Background/' + canvasData.canvas_bg_image;
      this.backgroundImageSet(this.bg_image_path);
      $("html, body").animate({
        scrollTop: 0
      }, "slow");
      this.canvasDataView(canvasData.canvas_objects);
    },
    canvasDataView: function canvasDataView(text_data) {
      var c = this.canvas;
      c.loadFromJSON(text_data, function () {
        c.renderAll();
      });
    },
    deleteObjects: function deleteObjects() {
      var canvas = this.canvas;
      var activeObjects = canvas.getActiveObjects();

      if (activeObjects.length) {
        // if (confirm('Do you want to delete the selected item??')) {
        activeObjects.forEach(function (object) {
          canvas.remove(object);
        });
      }

      this.obj_setting = 0; // } else {
      //     alert('Please select the drawing to delete')
      // }
    },
    deleteCanvas: function deleteCanvas(cmn_pdf_canvas_id) {
      var _this4 = this;

      this.delete_sweet().then(function (result) {
        if (result.value) {
          //Send Request to server
          axios.post(_this4.BASE_URL + 'api/delete_canvas', {
            cmn_pdf_canvas_id: cmn_pdf_canvas_id
          }).then(function (_ref3) {
            var data = _ref3.data;

            if (data.message == 'success') {
              _this4.alert_text = "Canvas deleted";
            } else if (data.message == 'faild') {
              _this4.alert_text = "Canvas not deleted";
            }

            _this4.alert_icon = data.class_name;
            _this4.alert_title = data.title;

            _this4.sweet_normal_alert();

            _this4.loadCanvasData();
          })["catch"](function () {
            _this4.sweet_advance_alert();
          });
        }
      });
    },
    bgImageChange: function bgImageChange(e) {
      var file = e.target.files[0];
      var reader = new FileReader();

      if (file.size < 2111775) {
        if (file.type == "image/png" || file.type == "image/jpeg") {
          var mainThis = this;

          reader.onload = function (e) {
            var base64_var = e.target.result;
            mainThis.bgImageProcess(base64_var);
            mainThis.update_image_info = 1;
          };

          reader.readAsDataURL(file);

          reader.onerror = function () {};
        } else {
          this.alert_text = 'File must me jpg or png';
          this.alert_title = "Warning!", this.alert_icon = "warning";
          this.sweet_normal_alert();
          $('#image').val('');
        }
      } else {
        this.alert_text = 'File size can not be bigger than 2 MB';
        this.alert_title = "Warning!", this.alert_icon = "warning";
        this.sweet_normal_alert();
        $('#image').val('');
      } //   this.form.image_url = URL.createObjectURL(file);

    },
    canvasClear: function canvasClear() {
      var obj = this.canvas.getObjects();
      this.canvas.remove(obj);
    },
    canvasFieldClear: function canvasFieldClear() {
      this.canvas_name = null;
      this.canvas_id = null;
      this.submit_button = 'Save';
      this.update_image_info = null;
      this.obj_setting = 0;
      this.selected_buyer = [];
      this.bg_image_path = this.BASE_URL + 'storage/app/public/backend/images/canvas/Background/bg_image.jpg';
      this.backgroundImageSet(this.bg_image_path);
    },
    bgImageProcess: function bgImageProcess(bg_image) {
      var img = new Image();
      var mainCanvas = this.canvas;

      img.onload = function () {
        var f_img = new fabric.Image(img);
        mainCanvas.setBackgroundImage(f_img, mainCanvas.renderAll.bind(mainCanvas), {
          // width: mainCanvas.width,
          // height: mainCanvas.height,
          originX: 'left',
          originY: 'top'
        });
        mainCanvas.setWidth(img.width);
        mainCanvas.setHeight(img.height);
      };

      img.src = bg_image;
    },
    clearCanvasObjects: function clearCanvasObjects() {
      this.canvas.clear();
      this.canvasFieldClear();
    },
    printCanvas: function printCanvas() {
      this.deselectObject();
      this.printData('.canvas-container');
    },
    deselectObject: function deselectObject() {
      var canvas = this.canvas;
      var activeObjects = canvas.getActiveObjects();

      if (activeObjects.length) {
        // if (confirm('Do you want to delete the selected item??')) {
        activeObjects.forEach(function (object) {
          canvas.discardActiveObject(object);
          canvas.renderAll();
        }); // }
      }
    },
    duplicateObjects: function duplicateObjects() {
      var _this5 = this;

      var _this = this;

      var activeObjects = this.canvas.getActiveObjects();
      var obj_copy = activeObjects;
      obj_copy.forEach(function (element) {
        _this5.createObj(element.left, element.top + 29, element.width, element.height, element.fontSize, element.textAlign, element.lineHeight, element.scaleX, element.scaleY, element.text.toString(), 'auto');
      });
    },
    printData: function printData(divVar) {
      var canvas = this.canvas;
      var thisVar = this;
      var imgSrc = canvas.backgroundImage._element.src;
      canvas.backgroundImage = 0;
      canvas.renderAll();
      var ppp = $(divVar).printThis({
        debug: false,
        // show the iframe for debugging
        importCSS: false,
        // import parent page css
        importStyle: false,
        // import style tags
        printContainer: true,
        // print outer container/$.selector
        loadCSS: Globals.base_url + "/public/css/pdf_css.css",
        // path to additional css file - use an array [] for multiple
        pageTitle: "0",
        // add title to print page
        removeInline: false,
        // remove inline styles from print elements
        removeInlineSelector: "*",
        // custom selectors to filter inline styles. removeInline must be true
        printDelay: 500,
        // variable print delay EX: 333
        header: null,
        // prefix to html or null
        footer: null,
        // postfix to html or null
        base: false,
        // preserve the BASE tag or accept a string for the URL
        formValues: true,
        // preserve input/form values
        canvas: true,
        // copy canvas content
        doctypeString: '',
        // enter a different doctype for older markup
        removeScripts: false,
        // remove script tags from print content
        copyTagClasses: false,
        // copy classes from the html & body tag
        beforePrintEvent: null,
        // function for printEvent in iframe
        beforePrint: null,
        // function called before iframe is filled
        afterPrint: null // function called before iframe is removed

      }); // console.log(ppp);

      setTimeout(function () {
        thisVar.backgroundImageSet(imgSrc);
      }, 510);
    },
    saveData: function saveData() {
      var _this6 = this;

      if (this.canvas_name == null) {
        alert("Please fill canvas name");
        return false;
      }

      if (this.selected_buyer.length <= 0) {
        alert("Please select buyer name");
        return false;
      }

      var canData = this.canvasData();

      if (!canData['objects'].length) {
        alert("No canvas drown");
        return false;
      }

      var buyer_id = this.selected_buyer.byr_buyer_id; // this.selected_buyer.forEach(element => {
      //   buyer_id.push(element.byr_buyer_id)
      // });

      var canvas_data = {
        canvas_id: this.canvas_id,
        update_image_info: this.update_image_info,
        byr_id: buyer_id,
        canvas_name: this.canvas_name,
        canData: canData,
        canvasImage: this.getCanvasBgImage()
      }; // console.log(canvas_data);
      // return 0;

      axios.post(this.BASE_URL + "api/canvas_data_save", canvas_data).then(function (_ref4) {
        var data = _ref4.data;

        if (data.message == 'created') {
          _this6.alert_text = "Canvas Created";

          _this6.loadCanvasData();

          _this6.canvas.clear();

          _this6.canvasFieldClear();
        } else if (data.message == 'updated') {
          _this6.alert_text = "Canvas Updated";

          _this6.loadCanvasData();
        } else if (data.message == 'duplicated') {
          _this6.alert_text = "Canvas Buyer is duplicated";
        }

        _this6.alert_title = data.title;
        _this6.alert_icon = data.class_name;

        _this6.sweet_normal_alert();
      })["catch"](function () {
        _this6.sweet_advance_alert();
      });
    },
    // createReactObj(){
    createObj: function createObj() {
      var left = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 100;
      var top = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 50;
      var width = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 150;
      var height = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 22;
      var fontSize = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : 20;
      var textAlign = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : "left";
      var lineHeight = arguments.length > 6 && arguments[6] !== undefined ? arguments[6] : 1.16;
      var scaleX = arguments.length > 7 && arguments[7] !== undefined ? arguments[7] : 1;
      var scaleY = arguments.length > 8 && arguments[8] !== undefined ? arguments[8] : 1;
      var text = arguments.length > 9 && arguments[9] !== undefined ? arguments[9] : "Created by default";
      var createdBy = arguments.length > 10 && arguments[10] !== undefined ? arguments[10] : 'auto';
      var activeObject = this.canvas.getActiveObject();
      var text_data = [{
        originX: "left",
        originY: "top",
        left: left,
        top: top,
        width: width,
        height: height,
        fill: "black",
        stroke: null,
        strokeWidth: 0,
        strokeDashArray: null,
        strokeLineCap: "butt",
        strokeDashOffset: 0,
        strokeLineJoin: "miter",
        strokeMiterLimit: 4,
        scaleX: scaleX,
        scaleY: scaleY,
        angle: 0,
        flipX: 0,
        //false
        flipY: 0,
        //false
        opacity: 1,
        shadow: null,
        visible: 1,
        //true
        clipTo: null,
        backgroundColor: "",
        fillRule: "nonzero",
        paintFirst: "fill",
        globalCompositeOperation: "source-over",
        transformMatrix: null,
        skewX: 0,
        skewY: 0,
        text: text,
        fontSize: fontSize,
        fontWeight: "normal",
        fontFamily: "Times New Roman",
        //Arial, Times New Roman, Helvetica, sans-serif
        fontStyle: "normal",
        lineHeight: lineHeight,
        underline: 0,
        //False
        overline: 0,
        //False
        linethrough: 0,
        //False
        textAlign: textAlign,
        textBackgroundColor: "",
        charSpacing: 0,
        minWidth: 20,
        splitByGrapheme: 1,
        //False
        objectCaching: false
      }];

      if (createdBy != 'auto') {
        if (!activeObject) {
          this.addText(text_data);
        }
      } else {
        this.addText(text_data);
      }
    },
    doubleClick: function doubleClick(option) {
      // console.log(option);
      this.pointerX = option.pointer.x;
      this.pointerY = option.pointer.y;
      this.createObj(this.pointerX - 50, this.pointerY, 150, 22, 20, "left", 1.16, 1, 1, "Created by Click", 'clicked');
      this.obj_setting = 1;
      this.getActiveObjectAttr();
    },
    getCanvasBgImage: function getCanvasBgImage() {
      var can_image = this.canvas.toDataURL({
        format: 'png',
        quality: 0.8
      });
      return can_image;
    },
    canvasData: function canvasData() {
      return this.canvas.toJSON();
    },
    backgroundImageSet: function backgroundImageSet(imgUrl) {
      var mainCanvas = this.canvas;
      this.canvas.setBackgroundImage(imgUrl, this.canvas.renderAll.bind(this.canvas), {
        // Optionally add an opacity lvl to the image
        backgroundImageOpacity: 0,
        // should the image be resized to fit the container?
        backgroundImageStretch: false // image size as canvas size
        // width: this.canvas.width,
        // height: this.canvas.height

      }); // canvas size by image size

      this.bgImageWH(imgUrl);
    },
    bgImageWH: function bgImageWH(imgUrl) {
      var mainCanvas = this.canvas;
      var img = new Image();
      img.src = imgUrl;

      img.onload = function () {
        mainCanvas.setWidth(img.naturalWidth);
        mainCanvas.setHeight(img.naturalHeight);
      };
    },
    mouseUp: function mouseUp(e) {
      this.getActiveObjectAttr();
    },
    getActiveObjectAttr: function getActiveObjectAttr() {
      var canvas = this.canvas;

      var _this = this;

      var activeObjects = canvas.getActiveObjects();

      if (activeObjects.length > 0) {
        this.obj_setting = 1;
        activeObjects.forEach(function (object) {
          _this.justifier = object.textAlign == "left" ? "left" : object.textAlign == "center" ? "center" : object.textAlign == "right" ? "right" : '';
          _this.fontSize = object.fontSize;
          _this.scaleX = object.scaleX;
          _this.scaleY = object.scaleY;
          _this.width = object.width;
          _this.height = object.height;
          _this.lineHeight = object.lineHeight; // _this.leftPos=activeObjects.length>1?object.group.left:object.left;
          // _this.topPos=activeObjects.length>1?object.group.top:object.top;

          _this.leftPos = activeObjects.length > 1 ? object.group.left.toFixed(2) : object.left.toFixed(2);
          _this.topPos = activeObjects.length > 1 ? object.group.top.toFixed(2) : object.top.toFixed(2);
        });
      } else {
        this.obj_setting = 0;
      }
    },
    getActiveObject: function getActiveObject() {
      this.activeObjects = this.canvas.getActiveObjects();
    },
    // changeObjectSetting($event=null){
    //   var canvas=this.canvas;
    //   var _this=this;
    //   this.getActiveObject()
    //   if (this.activeObjects.length) {
    //           this.activeObjects.forEach(function(object) {
    //             object.set({
    //             // textAlign:$event==null?_this.selectedJustifier.name:$event.name,
    //             width:Number(_this.width),
    //             height:Number(_this.height),
    //             // fontSize:Number(_this.fontSize),
    //             // strokeWidth: val,
    //             // scaleX: Number(_this.scaleX),
    //             // scaleY: Number(_this.scaleY),
    //             left: Number(_this.leftPos),
    //             top: Number(_this.topPos),
    //             lineHeight:Number(_this.lineHeight),
    //             evented: true,
    //         });
    //         // object.setCoords();
    //           });
    //           // canvas.setActiveObject(activeObjects);
    //           // canvas.requestRenderAll();
    //       }
    //       canvas.renderAll();
    // },
    changeJustifier: function changeJustifier(justifierVal) {
      var canvas = this.canvas; // var _this=this;

      this.getActiveObject();

      if (this.activeObjects.length) {
        this.activeObjects.forEach(function (object) {
          object.textAlign = justifierVal;
          canvas.renderAll();
        });
        this.justifier = justifierVal;
      }
    },
    changeFontSize: function changeFontSize() {
      var canvas = this.canvas;

      var _this = this;

      this.getActiveObject();

      if (this.activeObjects.length) {
        this.activeObjects.forEach(function (object) {
          object.fontSize = Number(_this.fontSize);
          canvas.renderAll();
        });
      }
    },
    changeScaleXSize: function changeScaleXSize() {
      var canvas = this.canvas;

      var _this = this;

      this.getActiveObject();

      if (_this.activeObjects.length) {
        _this.activeObjects.forEach(function (object) {
          object.scaleX = Number(_this.scaleX);
          canvas.renderAll();
        });
      }
    },
    changeScaleYSize: function changeScaleYSize() {
      var canvas = this.canvas;

      var _this = this;

      this.getActiveObject();

      if (_this.activeObjects.length) {
        _this.activeObjects.forEach(function (object) {
          object.scaleY = Number(_this.scaleY);
          canvas.renderAll();
        });
      }
    },
    changeObjectLeftPos: function changeObjectLeftPos() {
      var canvas = this.canvas;

      var _this = this;

      this.getActiveObject();

      if (_this.activeObjects.length) {
        canvas.discardActiveObject();

        _this.activeObjects.forEach(function (object) {
          object.left = Number(_this.leftPos); // object.evented= true,
          // object.setCoords();
          // object.set('active', true);
          // canvas.setActiveObject(object);
        });

        var selection = new fabric.ActiveSelection(_this.activeObjects, {
          canvas: canvas
        });
        canvas.setActiveObject(selection).renderAll();
      }
    },
    changeObjectTopPos: function changeObjectTopPos() {
      var canvas = this.canvas;

      var _this = this;

      this.getActiveObject();

      if (_this.activeObjects.length) {
        canvas.discardActiveObject();

        _this.activeObjects.forEach(function (object) {
          object.top = Number(_this.topPos);
        });

        var selection = new fabric.ActiveSelection(_this.activeObjects, {
          canvas: canvas
        });
        canvas.setActiveObject(selection).renderAll();
      }
    },
    changeObjectLineHeight: function changeObjectLineHeight() {
      var canvas = this.canvas;

      var _this = this;

      this.getActiveObject();

      if (_this.activeObjects.length) {
        _this.activeObjects.forEach(function (object) {
          object.lineHeight = Number(_this.lineHeight);
        });

        canvas.renderAll();
      }
    },
    changeObjectWidth: function changeObjectWidth() {
      var canvas = this.canvas;

      var _this = this;

      this.getActiveObject();

      if (_this.activeObjects.length) {
        _this.activeObjects.forEach(function (object) {
          object.width = Number(_this.width);
        });

        canvas.renderAll();
      }
    },
    addText: function addText(text_data) {
      for (var i = 0; i < text_data.length; i++) {
        var oText = new fabric.Textbox(text_data[i]['text'], {
          originX: text_data[i]['originX'],
          originY: text_data[i]['originY'],
          left: text_data[i]['left'],
          top: text_data[i]['top'],
          width: text_data[i]['width'],
          height: text_data[i]['height'],
          fill: text_data[i]['fill'],
          stroke: text_data[i]['stroke'],
          strokeWidth: text_data[i]['strokeWidth'],
          strokeDashArray: text_data[i]['strokeDashArray'],
          strokeLineCap: text_data[i]['strokeLineCap'],
          strokeDashOffset: text_data[i]['strokeDashOffset'],
          strokeLineJoin: text_data[i]['strokeLineJoin'],
          strokeMiterLimit: text_data[i]['strokeMiterLimit'],
          scaleX: text_data[i]['scaleX'],
          scaleY: text_data[i]['scaleY'],
          angle: text_data[i]['angle'],
          flipX: text_data[i]['flipX'],
          flipY: text_data[i]['flipY'],
          opacity: text_data[i]['opacity'],
          shadow: text_data[i]['shadow'],
          visible: text_data[i]['visible'],
          clipTo: text_data[i]['clipTo'],
          backgroundColor: text_data[i]['backgroundColor'],
          fillRule: text_data[i]['fillRule'],
          paintFirst: text_data[i]['paintFirst'],
          globalCompositeOperation: text_data[i]['globalCompositeOperation'],
          transformMatrix: text_data[i]['transformMatrix'],
          skewX: text_data[i]['skewX'],
          skewY: text_data[i]['skewY'],
          fontSize: text_data[i]['fontSize'],
          fontWeight: text_data[i]['fontWeight'],
          fontFamily: text_data[i]['fontFamily'],
          //Arial, Times New Roman, Helvetica, sans-serif
          fontStyle: text_data[i]['fontStyle'],
          lineHeight: text_data[i]['lineHeight'],
          underline: text_data[i]['underline'],
          overline: text_data[i]['overline'],
          linethrough: text_data[i]['linethrough'],
          textAlign: text_data[i]['textAlign'],
          textBackgroundColor: text_data[i]['textBackgroundColor'],
          charSpacing: text_data[i]['charSpacing'],
          minWidth: text_data[i]['minWidth'],
          splitByGrapheme: text_data[i]['splitByGrapheme'],
          objectCaching: false // hasControls: false,

        });
        this.canvas.add(oText).setActiveObject(oText);
        this.canvas.renderAll();
      }
    },
    keyEventFunc: function keyEventFunc(e) {
      // console.log(e);
      // if (e.keyCode == 46 || (e.ctrlKey && e.keyCode == 8)) {
      if (e.keyCode == 46 || e.ctrlKey && e.keyCode == 8) {
        this.deleteObjects();
      } else if (e.ctrlKey && e.shiftKey && e.keyCode == 65) {
        this.selectAllObjects();
      } else if (e.ctrlKey && e.keyCode == 67) {
        this.copyObject();
      } else if (e.ctrlKey && e.keyCode == 86) {
        this.pasteObject();
      } else if (e.keyCode == 37) {
        this.leftButton();
      } else if (e.keyCode == 38) {
        this.upButton();
      } else if (e.keyCode == 39) {
        this.rightButton();
      } else if (e.keyCode == 40) {
        this.downButton();
      } else if (e.ctrlKey && e.keyCode == 90) {
        this.undo();
      }
    },
    leftButton: function leftButton() {
      var activeObjects = this.canvas.getActiveObjects();
      activeObjects.forEach(function (element) {
        element.set({
          left: element.left - 1,
          evented: true
        });
        element.setCoords();
      });
      this.canvas.requestRenderAll();
      this.getActiveObjectAttr();
    },
    upButton: function upButton() {
      var activeObjects = this.canvas.getActiveObjects();
      activeObjects.forEach(function (element) {
        element.set({
          top: element.top - 1,
          evented: true
        });
        element.setCoords();
      });
      this.canvas.requestRenderAll();
      this.getActiveObjectAttr();
    },
    rightButton: function rightButton() {
      var activeObjects = this.canvas.getActiveObjects();
      activeObjects.forEach(function (element) {
        element.set({
          left: element.left + 1,
          evented: true
        });
        element.setCoords();
      });
      this.canvas.requestRenderAll();
      this.getActiveObjectAttr();
    },
    downButton: function downButton() {
      var activeObjects = this.canvas.getActiveObjects();
      activeObjects.forEach(function (element) {
        element.set({
          top: element.top + 1,
          evented: true
        });
        element.setCoords();
      });
      this.canvas.requestRenderAll();
      this.getActiveObjectAttr();
    },
    undo: function undo() {
      var canvas = this.canvas;

      var _this = this; // https://bountify.co/adding-keyboard-functions-to-undo-redo-functionality-on-fabric-js
      // https://jsfiddle.net/gableroux/tv29xfkg/10/
      // if(canvas.mementoConfig.undoFinishedStatus){
      //     if(canvas.mementoConfig.currentStateIndex === -1){
      //         canvas.mementoConfig.undoStatus = false;
      //     }
      //     else{
      //         if (canvas.mementoConfig.canvasState.length >= 1) {
      //             canvas.mementoConfig.undoFinishedStatus = 0;
      //             if(canvas.mementoConfig.currentStateIndex != 0){
      //                 canvas.mementoConfig.undoStatus = true;
      //                 loadJsonIntoCanvas(JSON.parse(canvas.mementoConfig.canvasState[canvas.mementoConfig.currentStateIndex-1]).objects, canvas, true);
      //                 canvas.mementoConfig.undoStatus = false;
      //                 canvas.mementoConfig.currentStateIndex -= 1;
      //                 // $('#undo').prop('disabled', false);
      //                 if(canvas.mementoConfig.currentStateIndex !== canvas.mementoConfig.canvasState.length-1){
      //                     // $('#redo').prop('disabled', false);
      //                 }
      //                 canvas.mementoConfig.undoFinishedStatus = 1;
      //             }
      //             else if(canvas.mementoConfig.currentStateIndex === 0){
      //                 clearCanvas(canvas);
      //                 canvas.mementoConfig.undoFinishedStatus = 1;
      //                 // $('#undo').prop('disabled', true);
      //                 // $('#redo').prop('disabled', false);
      //                 canvas.mementoConfig.currentStateIndex -= 1;
      //             }
      //         }
      //     }
      // }

    },
    copyObject: function copyObject() {
      // copy function start
      var canvas = this.canvas;

      var _this = this;

      var activeObject = canvas.getActiveObject();

      if (activeObject) {
        activeObject.clone(function (cloned) {
          _this.copiedObjects = cloned;
        });
      } // Copy function End

    },
    pasteObject: function pasteObject() {
      var canvas = this.canvas;

      var _this = this;

      _this.copiedObjects.clone(function (clonedObj) {
        canvas.discardActiveObject();
        clonedObj.set({
          // left: clonedObj.left + 10,
          top: clonedObj.top + 30,
          evented: true
        });

        if (clonedObj.type === 'activeSelection') {
          // active selection needs a reference to the canvas.
          clonedObj.canvas = canvas;
          clonedObj.forEachObject(function (obj) {
            canvas.add(obj);
          }); // this should solve the unselectability

          clonedObj.setCoords();
        } else {
          canvas.add(clonedObj);
        }

        _this.copiedObjects.top += 30; // _this.copiedObjects.left += 10;

        canvas.setActiveObject(clonedObj);
        canvas.requestRenderAll();
      });
    },
    selectAllObjects: function selectAllObjects() {
      var _this = this;

      var selection = new fabric.ActiveSelection(this.canvas.getObjects(), {
        canvas: this.canvas
      });

      _this.canvas.setActiveObject(selection);

      _this.canvas.renderAll();

      if (selection._objects.length) {
        this.obj_setting = 1;
      }
    }
  },
  created: function created() {
    Fire.$emit('permission_check_for_buyer', this.$session.get('byr_buyer_id')); // this.canvasOpen();
  },
  mounted: function mounted() {
    var _this7 = this;

    this.canvas = new fabric.Canvas("c");
    this.canvas.setWidth(this.canvas_width);
    this.canvas.setHeight(this.canvas_height); // this.canvas.controlsAboveOverlay = true;

    this.bg_image_path = this.BASE_URL + 'storage/app/public/backend/images/canvas/Background/bg_image.jpg';
    this.backgroundImageSet(this.bg_image_path);
    this.loadCanvasData();
    this.canvas.on('mouse:dblclick', function (e) {
      _this7.doubleClick(e);
    });
    this.canvas.on('mouse:up', function (e) {
      _this7.mouseUp(e);
    });
    document.addEventListener('keyup', function (e) {
      _this7.keyEventFunc(e);
    });
    document.addEventListener('keydown', function (e) {
      if (e.keyCode == 46 || e.ctrlKey && e.keyCode == 8 || e.ctrlKey && e.shiftKey && e.keyCode == 65 || e.ctrlKey && e.keyCode == 67 || e.ctrlKey && e.keyCode == 86 || e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40 || e.ctrlKey && e.keyCode == 90) {
        e.preventDefault();
      }
    });
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.input-group{\n  min-width: 5rem\n}\n.justificationButton{\n      width: 30px;\n    padding: 0;\n    height: 30px;\n    margin-top: 4px;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./canvas.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/canvas.vue?vue&type=template&id=cad14284&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/canvas.vue?vue&type=template&id=cad14284& ***!
  \*****************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _vm._m(0),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-12" },
      [
        _c(
          "b-button",
          {
            staticStyle: { "margin-left": "1px" },
            attrs: { variant: "danger" },
            on: {
              click: function($event) {
                return _vm.deleteObjects()
              }
            }
          },
          [_vm._v("Delete")]
        ),
        _vm._v(" "),
        _c(
          "b-button",
          { attrs: { variant: "primary" }, on: { click: _vm.printCanvas } },
          [_vm._v("Print")]
        ),
        _vm._v(" "),
        _c(
          "b-button",
          {
            attrs: { variant: "info" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.backgroundModalFunc($event)
              }
            }
          },
          [_vm._v("Background")]
        ),
        _vm._v(" "),
        _c(
          "b-button",
          {
            attrs: { variant: "warning" },
            on: { click: _vm.clearCanvasObjects }
          },
          [_vm._v("Clear canvas")]
        ),
        _vm._v(" "),
        _c("br"),
        _vm._v(" "),
        _c("br"),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-4" },
            [
              _c(
                "multiselect",
                {
                  attrs: {
                    options: _vm.all_buyer,
                    searchable: true,
                    "close-on-select": true,
                    "show-labels": false,
                    placeholder: "Select buyers",
                    label: "company_name",
                    "track-by": "byr_buyer_id"
                  },
                  model: {
                    value: _vm.selected_buyer,
                    callback: function($$v) {
                      _vm.selected_buyer = $$v
                    },
                    expression: "selected_buyer"
                  }
                },
                [
                  _c(
                    "span",
                    { attrs: { slot: "noOptions" }, slot: "noOptions" },
                    [_vm._v("候補がありません")]
                  ),
                  _vm._v(" "),
                  _c(
                    "span",
                    { attrs: { slot: "noResult" }, slot: "noResult" },
                    [_vm._v("候補がありません")]
                  )
                ]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-3" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.canvas_name,
                  expression: "canvas_name"
                }
              ],
              staticClass: "form-control",
              staticStyle: { width: "300px !important" },
              attrs: { type: "text", placeholder: "Please enter canvas name" },
              domProps: { value: _vm.canvas_name },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.canvas_name = $event.target.value
                }
              }
            })
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-4" },
            [
              _c(
                "b-button",
                {
                  staticStyle: { "margin-left": "5px" },
                  attrs: { variant: "info" },
                  on: { click: _vm.saveData }
                },
                [_vm._v(_vm._s(_vm.submit_button))]
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _vm.obj_setting != 0
          ? _c("div", { staticClass: "row" }, [
              _c(
                "div",
                {
                  staticClass: "col-1",
                  staticStyle: { "padding-right": "0px" }
                },
                [
                  _c(
                    "b-button-group",
                    { staticClass: "mr-1" },
                    [
                      _c(
                        "b-button",
                        {
                          class: _vm.justifier == "left" ? "active" : "",
                          attrs: {
                            title: "Align left",
                            variant: "outline-secondary justificationButton",
                            size: "sm"
                          },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.changeJustifier("left")
                            }
                          }
                        },
                        [
                          _c("b-icon", {
                            attrs: { icon: "text-left", "aria-hidden": "true" }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-button",
                        {
                          class: _vm.justifier == "center" ? "active" : "",
                          attrs: {
                            title: "Align center",
                            variant: "outline-secondary justificationButton",
                            size: "sm"
                          },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.changeJustifier("center")
                            }
                          }
                        },
                        [
                          _c("b-icon", {
                            attrs: {
                              icon: "text-center",
                              "aria-hidden": "true"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-button",
                        {
                          class: _vm.justifier == "right" ? "active" : "",
                          attrs: {
                            title: "Align right",
                            variant: "outline-secondary justificationButton",
                            size: "sm"
                          },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.changeJustifier("right")
                            }
                          }
                        },
                        [
                          _c("b-icon", {
                            attrs: { icon: "text-right", "aria-hidden": "true" }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-1", staticStyle: { padding: "2px" } },
                [
                  _c(
                    "b-input-group",
                    { staticClass: "mb-2" },
                    [
                      _c(
                        "b-input-group-prepend",
                        { attrs: { "is-text": "" } },
                        [_c("b-icon", { attrs: { icon: "type" } })],
                        1
                      ),
                      _vm._v(" "),
                      _c("b-form-input", {
                        attrs: {
                          title: "Font Size",
                          type: "text",
                          placeholder: "Font Size"
                        },
                        on: {
                          keyup: function($event) {
                            return _vm.changeFontSize()
                          }
                        },
                        model: {
                          value: _vm.fontSize,
                          callback: function($$v) {
                            _vm.fontSize = $$v
                          },
                          expression: "fontSize"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-1", staticStyle: { padding: "2px" } },
                [
                  _c(
                    "b-input-group",
                    { staticClass: "mb-2" },
                    [
                      _c(
                        "b-input-group-prepend",
                        { attrs: { "is-text": "" } },
                        [
                          _vm._v(
                            "\n                        SX\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("b-form-input", {
                        attrs: {
                          type: "text",
                          title: "ScaleX",
                          placeholder: "ScaleX"
                        },
                        on: {
                          keyup: function($event) {
                            return _vm.changeScaleXSize()
                          }
                        },
                        model: {
                          value: _vm.scaleX,
                          callback: function($$v) {
                            _vm.scaleX = $$v
                          },
                          expression: "scaleX"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-1", staticStyle: { padding: "2px" } },
                [
                  _c(
                    "b-input-group",
                    { staticClass: "mb-2" },
                    [
                      _c(
                        "b-input-group-prepend",
                        { attrs: { "is-text": "" } },
                        [
                          _vm._v(
                            "\n                        SY\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("b-form-input", {
                        attrs: {
                          type: "text",
                          title: "ScaleY",
                          placeholder: "ScaleY"
                        },
                        on: {
                          keyup: function($event) {
                            return _vm.changeScaleYSize()
                          }
                        },
                        model: {
                          value: _vm.scaleY,
                          callback: function($$v) {
                            _vm.scaleY = $$v
                          },
                          expression: "scaleY"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-1", staticStyle: { padding: "2px" } },
                [
                  _c(
                    "b-input-group",
                    { staticClass: "mb-2" },
                    [
                      _c(
                        "b-input-group-prepend",
                        { attrs: { "is-text": "" } },
                        [
                          _vm._v(
                            "\n                        X\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("b-form-input", {
                        attrs: {
                          type: "text",
                          title: "Left",
                          placeholder: "Left"
                        },
                        on: {
                          keyup: function($event) {
                            return _vm.changeObjectLeftPos()
                          }
                        },
                        model: {
                          value: _vm.leftPos,
                          callback: function($$v) {
                            _vm.leftPos = $$v
                          },
                          expression: "leftPos"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-1", staticStyle: { padding: "2px" } },
                [
                  _c(
                    "b-input-group",
                    { staticClass: "mb-2" },
                    [
                      _c(
                        "b-input-group-prepend",
                        { attrs: { "is-text": "" } },
                        [
                          _vm._v(
                            "\n                        Y\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("b-form-input", {
                        attrs: {
                          type: "text",
                          title: "Top",
                          placeholder: "Top"
                        },
                        on: {
                          keyup: function($event) {
                            return _vm.changeObjectTopPos()
                          }
                        },
                        model: {
                          value: _vm.topPos,
                          callback: function($$v) {
                            _vm.topPos = $$v
                          },
                          expression: "topPos"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-1", staticStyle: { padding: "2px" } },
                [
                  _c(
                    "b-input-group",
                    { staticClass: "mb-2" },
                    [
                      _c(
                        "b-input-group-prepend",
                        { attrs: { "is-text": "" } },
                        [_c("b-icon", { attrs: { icon: "type-h1" } })],
                        1
                      ),
                      _vm._v(" "),
                      _c("b-form-input", {
                        attrs: {
                          type: "text",
                          title: "Line Height",
                          placeholder: "Line Height"
                        },
                        on: {
                          keyup: function($event) {
                            return _vm.changeObjectLineHeight()
                          }
                        },
                        model: {
                          value: _vm.lineHeight,
                          callback: function($$v) {
                            _vm.lineHeight = $$v
                          },
                          expression: "lineHeight"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-1", staticStyle: { padding: "2px" } },
                [
                  _c(
                    "b-input-group",
                    { staticClass: "mb-2" },
                    [
                      _c(
                        "b-input-group-prepend",
                        { attrs: { "is-text": "" } },
                        [_c("b-icon", { attrs: { icon: "crop" } })],
                        1
                      ),
                      _vm._v(" "),
                      _c("b-form-input", {
                        attrs: {
                          type: "text",
                          title: "Width",
                          placeholder: "Width"
                        },
                        on: {
                          keyup: function($event) {
                            return _vm.changeObjectWidth()
                          }
                        },
                        model: {
                          value: _vm.width,
                          callback: function($$v) {
                            _vm.width = $$v
                          },
                          expression: "width"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              )
            ])
          : _c("div", {
              staticClass: "row",
              staticStyle: { height: "47.5px" }
            }),
        _vm._v(" "),
        _c("br")
      ],
      1
    ),
    _vm._v(" "),
    _vm._m(1),
    _vm._v(" "),
    _c("div", { staticClass: "col-12" }, [
      _c(
        "div",
        {
          staticClass: "card card-small mb-8",
          staticStyle: { "margin-top": "25px" }
        },
        [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "card-body p-0 pb-3", attrs: { id: "canvasList" } },
            [
              _c("table", { staticClass: "table mb-0", attrs: { id: "" } }, [
                _vm._m(3),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.canvasAllData, function(canvasData, i) {
                    return _c("tr", { key: i }, [
                      _c("td", [_vm._v(_vm._s(i + 1))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(canvasData.canvas_name))]),
                      _vm._v(" "),
                      _c("td", [
                        _c("img", {
                          staticClass: "img-responsive img-thumbnail",
                          staticStyle: { border: "1px solid gray" },
                          attrs: {
                            src:
                              _vm.BASE_URL +
                              "storage/app/public/backend/images/canvas/Canvas_screenshoot/" +
                              canvasData.canvas_image,
                            alt: "No image",
                            width: "150",
                            height: "100"
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", {
                        domProps: {
                          innerHTML: _vm._s(
                            _vm.formatDate(canvasData.updated_at)
                          )
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c(
                            "b-button",
                            {
                              attrs: { variant: "info" },
                              on: {
                                click: function($event) {
                                  return _vm.editCanvas(canvasData)
                                }
                              }
                            },
                            [
                              _c("b-icon", {
                                attrs: {
                                  icon: "pencil-square",
                                  "font-scale": "1.2"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "b-button",
                            {
                              attrs: { variant: "danger" },
                              on: {
                                click: function($event) {
                                  return _vm.deleteCanvas(
                                    canvasData.cmn_pdf_canvas_id
                                  )
                                }
                              }
                            },
                            [
                              _c("b-icon", {
                                attrs: {
                                  icon: "trash-fill",
                                  "font-scale": "1.2"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ])
                  }),
                  0
                )
              ])
            ]
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-12" },
      [
        _c(
          "b-modal",
          {
            attrs: {
              size: "lg",
              "hide-backdrop": true,
              title: "Canvas Background Image",
              "ok-title": "Crop"
            },
            on: {
              cancel: function($event) {
                $event.preventDefault()
                return _vm.cancelImage($event)
              }
            },
            model: {
              value: _vm.backgroundModalShow,
              callback: function($$v) {
                _vm.backgroundModalShow = $$v
              },
              expression: "backgroundModalShow"
            }
          },
          [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-12" }, [
                _c("input", {
                  staticClass: "btn btn-accent",
                  attrs: { type: "file", accept: "image/*" },
                  on: {
                    change: function($event) {
                      return _vm.loadImage($event)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-12" },
                [
                  _c("cropper", {
                    staticClass: "cropper",
                    attrs: { src: _vm.modal_image },
                    on: { change: _vm.change }
                  })
                ],
                1
              )
            ])
          ]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-12" }, [
      _c("h2", { staticClass: "top_title text-center" }, [_vm._v("Canvas")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "col-12", staticStyle: { overflow: "auto" } },
      [
        _c("canvas", { attrs: { id: "c" } }, [
          _vm._v("Your browser does not support the canvas element.")
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header border-bottom" }, [
      _c("h6", { staticClass: "m-0" }, [_vm._v("Canvas List")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "bg-light" }, [
      _c("tr", [
        _c("th", [_vm._v("#")]),
        _vm._v(" "),
        _c("th", [_vm._v("Canvas Name")]),
        _vm._v(" "),
        _c("th", [_vm._v("Image")]),
        _vm._v(" "),
        _c("th", [_vm._v("Last Update")]),
        _vm._v(" "),
        _c("th", [_vm._v("Operation")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/components/backend/canvas.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/backend/canvas.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _canvas_vue_vue_type_template_id_cad14284___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./canvas.vue?vue&type=template&id=cad14284& */ "./resources/js/components/backend/canvas.vue?vue&type=template&id=cad14284&");
/* harmony import */ var _canvas_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./canvas.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/canvas.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _canvas_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./canvas.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _canvas_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _canvas_vue_vue_type_template_id_cad14284___WEBPACK_IMPORTED_MODULE_0__["render"],
  _canvas_vue_vue_type_template_id_cad14284___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/canvas.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/canvas.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/backend/canvas.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./canvas.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/canvas.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css& ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./canvas.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/canvas.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/backend/canvas.vue?vue&type=template&id=cad14284&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/backend/canvas.vue?vue&type=template&id=cad14284& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_template_id_cad14284___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./canvas.vue?vue&type=template&id=cad14284& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/canvas.vue?vue&type=template&id=cad14284&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_template_id_cad14284___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_canvas_vue_vue_type_template_id_cad14284___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);