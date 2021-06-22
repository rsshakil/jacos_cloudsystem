(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["order_details_canvas"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/order_details_canvas.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/order_details_canvas.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jspdf__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jspdf */ "./node_modules/jspdf/dist/jspdf.es.min.js");
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
      loader: "",
      allName: [],
      canvasSelectedName: [],
      canvasDataLength: 0,
      canvasAllData: [],
      positionObjects: [],
      itr: 0,
      prev: 0,
      next: 0,
      canvas: null,
      bg_image_path: null,
      canvas_name: null,
      canvas_id: null,
      byr_order_id: null,
      canvas_width: 1219,
      canvas_height: 510,
      pointerX: 100,
      pointerY: 50
    };
  },
  methods: {
    loadCanvasData: function loadCanvasData() {
      var _this = this;

      axios.post(this.BASE_URL + "api/load_canvas_data", {
        byr_order_id: this.byr_order_id,
        cmn_scenario_id: 2
      }).then(function (_ref) {
        var data = _ref.data;

        if (data.canvas_data.length > 0) {
          _this.allName = data.canvas_data;
          _this.canvasSelectedName = _this.allName[0];
          _this.bg_image_path = _this.BASE_URL + "storage/app/public/backend/images/canvas/Background/" + _this.allName[0].canvas_bg_image;

          _this.backgroundImageSet(_this.bg_image_path);
        }

        if (data.can_info) {
          _this.canvasAllData = data.can_info;
          _this.canvasDataLength = _this.canvasAllData.length;

          if (_this.canvasDataLength > 1) {
            _this.prev = 0;
            _this.next = _this.canvasDataLength - 1;
          }

          if (_this.canvasDataLength > 0) {
            _this.canvasDesign(_this.itr);
          }
        }

        _this.loader.hide();
      })["catch"](function () {
        _this.sweet_advance_alert();

        _this.loader.hide();
      });
    },
    canvasDesignLeft: function canvasDesignLeft() {
      this.prev -= 1;
      this.next += 1;
      this.itr -= 1;
      this.canvasDesign(this.itr);
    },
    canvasDesignRight: function canvasDesignRight() {
      this.prev += 1;
      this.next -= 1;
      this.itr += 1;
      this.canvasDesign(this.itr);
    },
    canvasDesign: function canvasDesign(iteration) {
      var _this2 = this;

      if (!this.canvasSelectedName) {
        alert("Please select canvas name");
        return 0;
      }

      this.clearCanvasObjects();

      if (this.canvasDataLength > 0) {
        var canvasAllDataArray = this.canvasAllData[iteration];

        if (canvasAllDataArray.length) {
          // var position_values= JSON.parse(this.canvasSelectedName.position_values);
          var position_values = JSON.parse(this.canvasSelectedName.canvas_objects).objects;
          position_values.forEach(function (element) {
            // console.log(element.text);
            var split_element = _this2.splitString(element.text);

            var item = "";

            if (split_element[1] < canvasAllDataArray.length) {
              // item=canvasAllDataArray[split_element[1]][split_element[0]];
              if (canvasAllDataArray[split_element[1]][split_element[0]] != null) {
                item = canvasAllDataArray[split_element[1]][split_element[0]];
              } else if (canvasAllDataArray[split_element[1]][split_element[0]] != null) {
                item = canvasAllDataArray[split_element[1]][split_element[0]];
              } else {
                item = split_element[0];
              } // "order_lot_inputs" not in database

            } else {
              if (!Array.isArray(split_element)) {
                if (split_element == "total_order_qty") {
                  item = canvasAllDataArray[0]['total_order_qty'];
                } else if (split_element == "total_selling_price") {
                  item = canvasAllDataArray[0]['total_selling_price'];
                } else if (split_element == "total_cost_price") {
                  item = canvasAllDataArray[0]['total_cost_price'];
                } else if (split_element == "total_confirm_quantity") {
                  item = canvasAllDataArray[0]['total_confirm_quantity'] == 0 ? "" : canvasAllDataArray[0]['total_confirm_quantity'];
                } else if (split_element == "center_code") {
                  item = canvasAllDataArray[0]['center_code'];
                } else if (split_element == "center_name") {
                  item = canvasAllDataArray[0]['center_name'];
                } else {
                  item = split_element;
                } // console.log(item);

              }
            } // console.log(item);


            _this2.createObj(element.left, element.top, element.width, element.height, element.fontSize, element.textAlign, element.lineHeight, element.scaleX, element.scaleY, item.toString(), 'auto');
          });
        }

        this.emptyObjRemove();
      }
    },
    emptyObjRemove: function emptyObjRemove() {
      var _this3 = this;

      var canvasAllObj = this.canvas.getObjects();

      if (canvasAllObj) {
        canvasAllObj.forEach(function (obj) {
          if (obj.text == "") {
            _this3.canvas.remove(obj);
          }
        });
      }
    },
    splitString: function splitString(givenString) {
      var first_part = givenString.substring(0, 5);
      var main_part = givenString.slice(5, -2);
      var last_part = givenString.slice(-1);
      var result = [];

      if (first_part == "[db]_") {
        result.push(main_part);
        result.push(last_part);
      } else {
        result = givenString;
      }

      return result;
    },
    showCanvasBg: function showCanvasBg($event) {
      this.canvasSelectedName = $event;
      this.bg_image_path = this.BASE_URL + "storage/app/public/backend/images/canvas/Background/" + $event.canvas_bg_image;
      this.backgroundImageSet(this.bg_image_path);
      this.canvasDesign(this.itr);
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
        if (confirm("Do you want to delete the selected item??")) {
          activeObjects.forEach(function (object) {
            canvas.remove(object);
          });
        }
      } else {
        alert("Please select the drawing to delete");
      }
    },
    canvasClear: function canvasClear() {
      var obj = this.canvas.getObjects();
      this.canvas.remove(obj);
    },
    canvasFieldClear: function canvasFieldClear() {
      this.canvas_name = null;
      this.canvas_id = null;
      this.submit_button = "Save";
      this.update_image_info = null;

      if (this.allName.length > 0) {
        this.bg_image_path = this.BASE_URL + "storage/app/public/backend/images/canvas/Background/" + this.allName[0].canvas_bg_image;
      } else {
        this.bg_image_path = this.BASE_URL + "storage/app/public/backend/images/canvas/Background/bg_image.jpg";
      }

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
          originX: "left",
          originY: "top"
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
    printAllCanvas: function printAllCanvas() {
      var _this4 = this;

      this.loader = Vue.$loading.show();
      var img_dym = this.bgImageDymension(this.bg_image_path);
      var doc = new jspdf__WEBPACK_IMPORTED_MODULE_0__["jsPDF"]({
        orientation: "landscape",
        unit: "in" // format: [15, 10]
        // format: [((img_dym.width)/96)+1, ((img_dym.height)/96)+1]

      });
      var imgSrc = this.bg_image_path;
      var canvas = this.canvas;
      canvas.backgroundImage = 0;
      canvas.renderAll();
      var all_image = "";

      var _loop = function _loop(i) {
        setTimeout(function () {
          _this4.deselectObject();

          _this4.canvasDesign(i);

          var image_data = _this4.canvas.toDataURL();

          doc.addImage(image_data, "", 0, 0);

          if (i != _this4.canvasDataLength - 1) {
            doc.addPage();
          } // console.log(image_data);

        }, 500);
      };

      for (var i = 0; i < this.canvasDataLength; i++) {
        _loop(i);
      }

      setTimeout(function () {
        doc.autoPrint();
        var oHiddFrame = document.createElement("iframe");
        oHiddFrame.style.position = "fixed";
        oHiddFrame.style.visibility = "hidden";
        oHiddFrame.src = doc.output('bloburl');
        document.body.appendChild(oHiddFrame); // window.open(doc.output('bloburl'), '_blank');

        _this4.canvasDesign(_this4.itr);

        _this4.loader.hide();
      }, this.canvasDataLength * 500); // this.canvasDesign(this.itr);
    },
    printSingleCanvas: function printSingleCanvas() {
      var _this5 = this;

      this.loader = Vue.$loading.show();
      this.deselectObject();
      this.printData(".canvas-container");
      setTimeout(function () {
        _this5.loader.hide();
      }, 510);
    },
    printData: function printData(divVar) {
      var canvas = this.canvas;
      var thisVar = this;
      var imgSrc = this.bg_image_path; // var imgSrc = canvas.backgroundImage._element.src;

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
        doctypeString: "",
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
        thisVar.backgroundImageSet(imgSrc); // this.loader.hide();
      }, 510);
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
        originX: 'left',
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
    addText: function addText(text_data) {
      for (var i = 0; i < text_data.length; i++) {
        var oText = new fabric.Textbox(text_data[i]["text"], {
          originX: text_data[i]["originX"],
          originY: text_data[i]["originY"],
          left: text_data[i]["left"],
          top: text_data[i]["top"],
          width: text_data[i]["width"],
          height: text_data[i]["height"],
          fill: text_data[i]["fill"],
          stroke: text_data[i]["stroke"],
          strokeWidth: text_data[i]["strokeWidth"],
          strokeDashArray: text_data[i]["strokeDashArray"],
          strokeLineCap: text_data[i]["strokeLineCap"],
          strokeDashOffset: text_data[i]["strokeDashOffset"],
          strokeLineJoin: text_data[i]["strokeLineJoin"],
          strokeMiterLimit: text_data[i]["strokeMiterLimit"],
          scaleX: text_data[i]["scaleX"],
          scaleY: text_data[i]["scaleY"],
          angle: text_data[i]["angle"],
          flipX: text_data[i]["flipX"],
          flipY: text_data[i]["flipY"],
          opacity: text_data[i]["opacity"],
          shadow: text_data[i]["shadow"],
          visible: text_data[i]["visible"],
          clipTo: text_data[i]["clipTo"],
          backgroundColor: text_data[i]["backgroundColor"],
          fillRule: text_data[i]["fillRule"],
          paintFirst: text_data[i]["paintFirst"],
          globalCompositeOperation: text_data[i]["globalCompositeOperation"],
          transformMatrix: text_data[i]["transformMatrix"],
          skewX: text_data[i]["skewX"],
          skewY: text_data[i]["skewY"],
          fontSize: text_data[i]["fontSize"],
          fontWeight: text_data[i]["fontWeight"],
          fontFamily: text_data[i]["fontFamily"],
          //Arial, Times New Roman, Helvetica, sans-serif
          fontStyle: text_data[i]["fontStyle"],
          lineHeight: text_data[i]["lineHeight"],
          underline: text_data[i]["underline"],
          overline: text_data[i]["overline"],
          linethrough: text_data[i]["linethrough"],
          textAlign: text_data[i]["textAlign"],
          textBackgroundColor: text_data[i]["textBackgroundColor"],
          charSpacing: text_data[i]["charSpacing"],
          minWidth: text_data[i]["minWidth"],
          splitByGrapheme: text_data[i]["splitByGrapheme"],
          objectCaching: false // hasControls: false,

        });
        this.canvas.add(oText).setActiveObject(oText);
        this.canvas.renderAll();
      }
    },
    doubleClick: function doubleClick(option) {
      // console.log(option);
      this.pointerX = option.pointer.x;
      this.pointerY = option.pointer.y;
      this.createObj(this.pointerX - 50, this.pointerY, 150, 22, 20, "left", 1.16, 1, 1, "Created by Click", 'clicked');
    },
    getCanvasBgImage: function getCanvasBgImage() {
      var can_image = this.canvas.toDataURL({
        format: "png",
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

      this.bgImageWH(imgUrl); // var img_dym=this.bgImageDymension(imgUrl);
      // mainCanvas.setWidth(img_dym.width);
      // mainCanvas.setHeight(img_dym.height);
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
    bgImageDymension: function bgImageDymension(imgUrl) {
      var img = new Image();
      img.src = imgUrl; // img.onload = function () {

      var img_W = img.naturalWidth;
      var img_H = img.naturalHeight; // };

      var imageDymension = {
        width: img_W,
        height: img_H
      };
      return imageDymension;
    } // }

  },
  created: function created() {// this.canvasOpen();
  },
  mounted: function mounted() {
    var _this6 = this;

    this.loader = Vue.$loading.show();
    this.byr_order_id = this.$route.params.byr_order_id;
    this.canvas = new fabric.Canvas("c");
    this.canvas.setWidth(this.canvas_width);
    this.canvas.setHeight(this.canvas_height); // this.canvas.controlsAboveOverlay = true;

    this.bg_image_path = this.BASE_URL + "storage/app/public/backend/images/canvas/Background/bg_image.jpg";
    this.backgroundImageSet(this.bg_image_path); // initAligningGuidelines(this.canvas);
    // initCenteringGuidelines(this.canvas);

    this.loadCanvasData();
    this.canvas.on("mouse:dblclick", function (e) {
      _this6.doubleClick(e);
    });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/order_details_canvas.vue?vue&type=template&id=212ed4ec&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/order_details_canvas.vue?vue&type=template&id=212ed4ec& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "col-12" }, [
      _vm._m(1),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "active-pink-3 active-pink-4 mb-1",
          staticStyle: {
            "margin-left": "10px",
            "max-width": "100%",
            float: "left"
          }
        },
        [
          _c("b-button", { attrs: { pill: "", variant: "info" } }, [
            _vm._v("Button")
          ])
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "col-12" }, [
      _c("div", { staticClass: "row" }, [
        _vm._m(2),
        _vm._v(" "),
        _vm._m(3),
        _vm._v(" "),
        _c("div", { staticClass: "col-2 text-center" }, [
          _c("div", { staticClass: "card mb-4 box-shadow" }, [
            _vm._m(4),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "card-body p-0 d-flex flex-column justify-content-between"
              },
              [
                _c("div", [
                  _c(
                    "div",
                    { staticClass: "form-group mb-0" },
                    [
                      _c(
                        "multiselect",
                        {
                          attrs: {
                            options: _vm.allName,
                            searchable: true,
                            "close-on-select": true,
                            "show-labels": false,
                            "selected-label": "選択中",
                            placeholder: "Canvas name",
                            label: "canvas_name",
                            "track-by": "cmn_pdf_canvas_id"
                          },
                          on: {
                            select: function($event) {
                              return _vm.showCanvasBg($event)
                            }
                          },
                          model: {
                            value: _vm.canvasSelectedName,
                            callback: function($$v) {
                              _vm.canvasSelectedName = $$v
                            },
                            expression: "canvasSelectedName"
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
                  )
                ])
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col" })
      ])
    ]),
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
          {
            attrs: { variant: "primary" },
            on: { click: _vm.printSingleCanvas }
          },
          [_vm._v("Print This Page")]
        ),
        _vm._v(" "),
        _c(
          "b-button",
          { attrs: { variant: "primary" }, on: { click: _vm.printAllCanvas } },
          [_vm._v("Print All Page")]
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
        _c(
          "b-button",
          {
            staticStyle: { "margin-left": "1px" },
            attrs: { variant: "warning" },
            on: {
              click: function($event) {
                return _vm.canvasDesign(_vm.itr)
              }
            }
          },
          [_vm._v("Reset Canvas")]
        ),
        _vm._v(" "),
        _c("br"),
        _vm._v(" "),
        _c("canvas", { attrs: { id: "c" } }, [
          _vm._v("Your browser does not support the canvas element.")
        ])
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-12 text-center" },
      [
        _c("span", [
          _vm._v(
            _vm._s(_vm.itr + 1) + " of " + _vm._s(_vm.canvasDataLength) + " "
          )
        ]),
        _vm._v(" "),
        _vm.canvasDataLength > 1
          ? _c(
              "b-button",
              {
                attrs: {
                  pill: "",
                  variant: "info",
                  disabled: _vm.prev == 0 ? true : false
                },
                on: { click: _vm.canvasDesignLeft }
              },
              [
                _c("b-icon", {
                  attrs: { icon: "caret-left", "font-scale": "3" }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.canvasDataLength > 1
          ? _c(
              "b-button",
              {
                attrs: {
                  pill: "",
                  variant: "info",
                  disabled: _vm.next == 0 ? true : false
                },
                on: { click: _vm.canvasDesignRight }
              },
              [
                _c("b-icon", {
                  attrs: { icon: "caret-right", "font-scale": "3" }
                })
              ],
              1
            )
          : _vm._e()
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
      {
        staticClass: "input-group mb-1",
        staticStyle: {
          "margin-left": "10px",
          "max-width": "250px",
          float: "left"
        }
      },
      [
        _c("div", { staticClass: "input-group-prepend" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-outline-primary",
              attrs: { type: "button" }
            },
            [_vm._v("小売選択")]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-control" }, [_vm._v("Name")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-2 text-center" }, [
      _c("div", { staticClass: "card mb-4 box-shadow" }, [
        _c("div", { staticClass: "card-header" }, [
          _c("p", { staticClass: "my-0 font-weight-normal" }, [
            _vm._v("発注日")
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "card-body p-0 d-flex flex-column justify-content-between"
          },
          [
            _c("div", [
              _c("div", { staticClass: "form-group mb-0 form-control" }, [
                _vm._v("2020-07-02")
              ])
            ])
          ]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-2 text-center" }, [
      _c("div", { staticClass: "card mb-4 box-shadow" }, [
        _c("div", { staticClass: "card-header" }, [
          _c("p", { staticClass: "my-0 font-weight-normal" }, [
            _vm._v("納品日")
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "card-body p-0 d-flex flex-column justify-content-between"
          },
          [
            _c("div", [
              _c("div", { staticClass: "form-group mb-0 form-control" }, [
                _vm._v("2020-07-02")
              ])
            ])
          ]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("p", { staticClass: "my-0 font-weight-normal" }, [
        _vm._v("Canvas name")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/order_details_canvas.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/backend/order_details_canvas.vue ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _order_details_canvas_vue_vue_type_template_id_212ed4ec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./order_details_canvas.vue?vue&type=template&id=212ed4ec& */ "./resources/js/components/backend/order_details_canvas.vue?vue&type=template&id=212ed4ec&");
/* harmony import */ var _order_details_canvas_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./order_details_canvas.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/order_details_canvas.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _order_details_canvas_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _order_details_canvas_vue_vue_type_template_id_212ed4ec___WEBPACK_IMPORTED_MODULE_0__["render"],
  _order_details_canvas_vue_vue_type_template_id_212ed4ec___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/order_details_canvas.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/order_details_canvas.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/backend/order_details_canvas.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_order_details_canvas_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./order_details_canvas.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/order_details_canvas.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_order_details_canvas_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/order_details_canvas.vue?vue&type=template&id=212ed4ec&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/backend/order_details_canvas.vue?vue&type=template&id=212ed4ec& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_order_details_canvas_vue_vue_type_template_id_212ed4ec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./order_details_canvas.vue?vue&type=template&id=212ed4ec& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/order_details_canvas.vue?vue&type=template&id=212ed4ec&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_order_details_canvas_vue_vue_type_template_id_212ed4ec___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_order_details_canvas_vue_vue_type_template_id_212ed4ec___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);