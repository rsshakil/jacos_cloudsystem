(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["pdf_platform_view"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************/
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
      myItr: 0,
      itr: 0,
      prev: 0,
      next: 0,
      canvas: null,
      bg_image_path: null,
      canvas_name: null,
      canvas_id: null,
      data_order_id: 1,
      canvas_width: 790,
      canvas_height: 1040,
      // canvas_width: 1219,
      // canvas_height: 510,
      pointerX: 100,
      pointerY: 50,
      line_gap: 28,
      printBg: false,
      line_per_page: 26,
      scenario_id: 14
    };
  },
  methods: {
    loadCanvasData: function loadCanvasData() {
      var _this2 = this;

      axios.post(this.BASE_URL + "api/load_pdf_platform_canvas_data", {
        data_order_id: this.data_order_id,
        scenario_id: this.scenario_id,
        line_per_page: this.line_per_page
      }).then(function (_ref) {
        var data = _ref.data;
        var canvas_data = data.canvas_data;

        if (canvas_data.length > 0) {
          _this2.allName = canvas_data;
          _this2.canvasSelectedName = _this2.allName[0];
          _this2.line_gap = Number(_this2.canvasSelectedName.line_gap);

          if (_this2.allName[0].canvas_bg_image) {
            _this2.bg_image_path = _this2.BASE_URL + "storage/app/public/backend/images/canvas/pdf_platform/Background/" + _this2.allName[0].canvas_bg_image;

            _this2.backgroundImageSet(_this2.bg_image_path);
          }
        }

        if (data.can_info.length > 0) {
          _this2.canvasAllData = data.can_info;
          _this2.canvasDataLength = _this2.canvasAllData.length;

          if (_this2.canvasDataLength > 0) {
            _this2.prev = 0;
            _this2.next = Math.ceil(_this2.canvasDataLength) - 1; //   this.next=(this.canvasDataLength-1);

            _this2.canvasDesign(_this2.itr);
          } // if (this.canvasDataLength>0) {
          // }

        } else {//   this.canvasDesign(this.itr)
          }
      })["catch"](function () {
        _this2.sweet_advance_alert();
      });
    },
    canvasDesignLeft: function canvasDesignLeft() {
      this.myItr -= 1;
      this.prev -= 2;
      this.next += 2;
      this.itr -= 2;
      this.canvasDesign(this.itr);
    },
    canvasDesignRight: function canvasDesignRight() {
      this.myItr += 1;
      this.prev += 2;
      this.next -= 2;
      this.itr += 2;
      this.canvasDesign(this.itr);
    },
    canvasDesign: function canvasDesign(iteration) {
      var _this3 = this;

      var loopVal = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
      var canvas = this.canvas;

      var _this = this;

      if (!this.canvasSelectedName) {
        alert("Please select canvas name");
        return 0;
      }

      this.clearCanvasObjects(loopVal); //   if (this.canvasDataLength>0) {

      var position_values = JSON.parse(this.canvasSelectedName.canvas_objects).objects;
      position_values.forEach(function (element) {
        if (element.type === "textbox") {
          var positionTop = element.top;

          var split_element = _this3.splitString(element.text);

          var item = '';

          if (!Array.isArray(split_element)) {
            item = split_element;

            _this3.createObj(element.left, element.top, element.width, element.height, element.fontSize, element.textAlign, element.lineHeight, element.scaleX, element.scaleY, item.toString(), 'auto');
          } else {
            if (split_element.length > 2) {
              //    console.log(iteration)
              if (split_element[2] == 0) {
                if (split_element[0] == "mes_lis_ord_tra_ins_goods_classification_code") {
                  //    item = this.getbyrjsonValueBykeyName(
                  //     "mes_lis_ord_tra_ins_goods_classification_code",
                  //     '01',
                  //     "orders"
                  //     )
                  //     console.log("My Item",item);
                  item = _this3.canvasAllData[iteration][0][split_element[0]];
                } else {
                  item = _this3.canvasAllData[iteration][0][split_element[0]];
                }
              } else {
                if (typeof _this3.canvasAllData[iteration + 1] !== 'undefined') {
                  if (Object.keys(_this3.canvasAllData[iteration + 1])[0]) {
                    if (split_element[0] == "mes_lis_ord_tra_ins_goods_classification_code") {
                      item = _this3.canvasAllData[iteration + 1][0][split_element[0]];
                    } else {
                      item = _this3.canvasAllData[iteration + 1][0][split_element[0]];
                    }
                  } else {
                    item = '';
                  }
                } else {
                  item = '';
                }
              }

              _this3.createObj(element.left, element.top, element.width, element.height, element.fontSize, element.textAlign, element.lineHeight, element.scaleX, element.scaleY, item.toString(), 'auto');
            } else {
              //    return 0;
              for (var i = 0; i < _this3.canvasAllData[iteration].length; i++) {
                if (split_element[1] == 0) {
                  item = _this3.canvasAllData[iteration][i][split_element[0]];
                } else {
                  if (typeof _this3.canvasAllData[iteration + 1] !== 'undefined') {
                    if (Object.keys(_this3.canvasAllData[iteration + 1])[i]) {
                      item = _this3.canvasAllData[iteration + 1][i][split_element[0]];
                    } else {
                      item = '';
                    }
                  } else {
                    item = '';
                  }
                }

                _this3.createObj(element.left, positionTop, element.width, element.height, element.fontSize, element.textAlign, element.lineHeight, element.scaleX, element.scaleY, item.toString(), 'auto');

                positionTop += _this3.line_gap;
              }
            }
          }
        } else {
          if (element.type == "line") {
            var line = new fabric.Line([Number(element.left), Number(element.top), Number(element.width), Number(element.top)], {
              stroke: 'black'
            });
            canvas.add(line);
          } else if (element.type == "rect") {
            var rect = new fabric.Rect({
              left: Number(element.left),
              top: Number(element.top),
              width: Number(element.width),
              height: Number(element.height),
              fill: element.fill,
              angle: Number(element.angle),
              padding: Number(element.padding)
            });
            canvas.add(rect);
          } else if (element.type == "circle") {
            var circle = new fabric.Circle({
              left: element.left,
              top: element.top,
              radius: element.radius,
              fill: element.fill,
              stroke: element.stroke,
              strokeWidth: element.strokeWidth
            });
            canvas.add(circle);
          } else {// console.log(element);
          }
        }
      }); // }

      this.emptyObjRemove(); //   }
    },
    emptyObjRemove: function emptyObjRemove() {
      var _this4 = this;

      var canvasAllObj = this.canvas.getObjects();

      if (canvasAllObj) {
        canvasAllObj.forEach(function (obj) {
          if (obj.text == "") {
            _this4.canvas.remove(obj);
          }
        });
      }
    },
    splitString: function splitString(givenString) {
      var first_part = givenString.substring(0, 6);
      var last_part = givenString.slice(-1);
      var main_part = "";

      if (last_part == 0) {
        main_part = givenString.slice(6, -2);
      } else {
        main_part = givenString.slice(6);
      }

      var result = [];

      if (first_part == "[db0]_" && last_part == 0) {
        result.push(main_part);
        result.push(last_part);
        result.push(0);
      } else if (first_part == "[db0]_" && last_part != 0) {
        result.push(main_part);
        result.push(0);
      } else if (first_part == "[db1]_" && last_part == 0) {
        result.push(main_part);
        result.push(last_part);
        result.push(1);
      } else if (first_part == "[db1]_" && last_part != 0) {
        result.push(main_part);
        result.push(1);
      } else {
        result = givenString;
      }

      return result;
    },
    showCanvasBg: function showCanvasBg($event) {
      this.canvasSelectedName = $event;

      if ($event.canvas_bg_image) {
        this.bg_image_path = this.BASE_URL + "storage/app/public/backend/images/canvas/pdf_platform/Background/" + $event.canvas_bg_image;
        this.backgroundImageSet(this.bg_image_path);
      }

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
      var loopVal = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

      var _this = this;

      if (_this.allName.length > 0) {
        if (_this.allName[0].canvas_bg_image) {
          //   console.log((_this.allName)[0].canvas_bg_image)
          _this.bg_image_path = _this.BASE_URL + "storage/app/public/backend/images/canvas/pdf_platform/Background/" + _this.allName[0].canvas_bg_image;

          _this.backgroundImageSet(_this.bg_image_path);
        } else {
          _this.canvas.setBackgroundColor("#fff");
        } // }

      }
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
      var loopVal = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

      // this.canvasClear();
      var _this = this;

      if (loopVal == 1) {
        var obj = _this.canvas.getObjects();

        obj.forEach(function (o) {
          _this.canvas.remove(o);
        });

        if (_this.allName.length > 0) {
          if (_this.allName[0].canvas_bg_image) {
            // console.log((_this.allName)[0].canvas_bg_image)
            _this.bg_image_path = _this.BASE_URL + "storage/app/public/backend/images/canvas/pdf_platform/Background/" + _this.allName[0].canvas_bg_image;

            _this.backgroundImageSet(_this.bg_image_path);
          } else {
            _this.canvas.setBackgroundColor("#fff");
          }
        } // this.canvas.renderAll();

      } else {
        this.canvas.clear();
        this.canvasFieldClear(loopVal);
      }
    },
    printAllCanvas: function printAllCanvas() {
      var _this5 = this;

      this.loader = Vue.$loading.show();
      var img_dym = this.bgImageDymension(this.bg_image_path);
      var doc = new jspdf__WEBPACK_IMPORTED_MODULE_0__["jsPDF"]({
        orientation: "portrait",
        //portrait or landscape
        unit: "in" // format: [15, 10]
        // format: [((img_dym.width)/96)+1, ((img_dym.height)/96)+1]

      });
      var imgSrc = this.bg_image_path;
      var canvas = this.canvas;

      var _loop = function _loop(i) {
        setTimeout(function () {
          if (_this5.printBg == false) {
            if (imgSrc) {
              // var imgSrc = canvas.backgroundImage._element.src;
              canvas.backgroundImage = 0;
              canvas.renderAll();
            }
          }

          _this5.deselectObject();

          _this5.canvasDesign(i, 1);

          var image_data = _this5.canvas.toDataURL();

          doc.addImage(image_data, "", 0, 0);

          if (i != _this5.canvasDataLength - 1) {
            doc.addPage();
          } // console.log(image_data);

        }, 400);
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

        _this5.canvasDesign(_this5.itr);

        _this5.loader.hide();
      }, this.canvasDataLength * 300); // this.canvasDesign(this.itr);
    },
    printSingleCanvas: function printSingleCanvas() {
      var _this6 = this;

      this.loader = Vue.$loading.show();
      this.deselectObject();
      this.printData(".canvas-container");
      setTimeout(function () {
        _this6.loader.hide();
      }, 510);
    },
    printData: function printData(divVar) {
      var canvas = this.canvas;
      var thisVar = this;
      var imgSrc = this.bg_image_path;

      if (this.printBg == false) {
        if (imgSrc) {
          // var imgSrc = canvas.backgroundImage._element.src;
          canvas.backgroundImage = 0;
          canvas.renderAll();
        }
      } // var imgSrc = canvas.backgroundImage._element.src;
      // canvas.backgroundImage = 0;
      // canvas.renderAll();


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

      if (this.printBg == false) {
        // console.log()
        if (imgSrc) {
          setTimeout(function () {
            thisVar.backgroundImageSet(imgSrc);
            thisVar.loader.hide();
          }, 510);
        }
      }
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
      mainCanvas.setBackgroundImage(imgUrl, mainCanvas.renderAll.bind(mainCanvas), {
        // Optionally add an opacity lvl to the image
        backgroundImageOpacity: 0,
        // should the image be resized to fit the container?
        backgroundImageStretch: false // image size as canvas size
        //   width: this.canvas.width,
        //   height: this.canvas.height

      }); // console.log(imgUrl);
      // canvas size by image size

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
  created: function created() {
    // console.log("Byter ID",this.$session.get('byr_buyer_id'));
    Fire.$emit('permission_check_for_buyer', this.$session.get('byr_buyer_id')); // this.canvasOpen();
  },
  mounted: function mounted() {
    var _this7 = this;

    // this.data_order_id = this.$route.params.data_order_id;
    this.canvas = new fabric.Canvas("c");
    this.canvas.setWidth(this.canvas_width);
    this.canvas.setHeight(this.canvas_height);
    this.canvas.setBackgroundColor("#fff"); // this.canvas.controlsAboveOverlay = true;
    // this.bg_image_path = this.BASE_URL + "storage/app/public/backend/images/canvas/pdf_platform/Background/bg_image.png";
    // this.backgroundImageSet(this.bg_image_path);
    // initAligningGuidelines(this.canvas);
    // initCenteringGuidelines(this.canvas);

    this.loadCanvasData();
    this.canvas.on("mouse:dblclick", function (e) {
      _this7.doubleClick(e);
    });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=template&id=d3d0878a&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=template&id=d3d0878a& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
        _c("label", { attrs: { for: "printBg" } }, [
          _vm._v("Print Background")
        ]),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.printBg,
              expression: "printBg"
            }
          ],
          attrs: { type: "checkbox", id: "printBg" },
          domProps: {
            checked: Array.isArray(_vm.printBg)
              ? _vm._i(_vm.printBg, null) > -1
              : _vm.printBg
          },
          on: {
            change: function($event) {
              var $$a = _vm.printBg,
                $$el = $event.target,
                $$c = $$el.checked ? true : false
              if (Array.isArray($$a)) {
                var $$v = null,
                  $$i = _vm._i($$a, $$v)
                if ($$el.checked) {
                  $$i < 0 && (_vm.printBg = $$a.concat([$$v]))
                } else {
                  $$i > -1 &&
                    (_vm.printBg = $$a.slice(0, $$i).concat($$a.slice($$i + 1)))
                }
              } else {
                _vm.printBg = $$c
              }
            }
          }
        }),
        _vm._v(" "),
        _c("br"),
        _vm._v(" "),
        _c("br")
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "col-12",
        staticStyle: { height: "500px", overflow: "auto" }
      },
      [
        _c("center", [
          _c("canvas", { attrs: { id: "c" } }, [
            _vm._v("Your browser does not support the canvas element.")
          ])
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
            _vm._s(_vm.canvasDataLength == 0 ? 0 : _vm.myItr + 1) +
              " of " +
              _vm._s(Math.ceil(_vm.canvasDataLength / 2)) +
              " "
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
                  disabled: _vm.prev <= 0 ? true : false
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
                  disabled: _vm.next <= 0 ? true : false
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

/***/ "./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pdf_platform_view_vue_vue_type_template_id_d3d0878a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pdf_platform_view.vue?vue&type=template&id=d3d0878a& */ "./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=template&id=d3d0878a&");
/* harmony import */ var _pdf_platform_view_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./pdf_platform_view.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _pdf_platform_view_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _pdf_platform_view_vue_vue_type_template_id_d3d0878a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _pdf_platform_view_vue_vue_type_template_id_d3d0878a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pdf_platform_view_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./pdf_platform_view.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pdf_platform_view_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=template&id=d3d0878a&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=template&id=d3d0878a& ***!
  \***********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdf_platform_view_vue_vue_type_template_id_d3d0878a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./pdf_platform_view.vue?vue&type=template&id=d3d0878a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/PDF_PLATFORM/pdf_platform_view.vue?vue&type=template&id=d3d0878a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdf_platform_view_vue_vue_type_template_id_d3d0878a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdf_platform_view_vue_vue_type_template_id_d3d0878a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);