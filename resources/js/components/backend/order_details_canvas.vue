<template>
  <div class="row">
    <div class="col-12">
      <h2 class="top_title text-center">Canvas</h2>
    </div>
    <div class="col-12">
      <div class="input-group mb-1" style="margin-left: 10px;max-width: 250px; float: left;">
        <div class="input-group-prepend">
          <button class="btn btn-outline-primary" type="button">小売選択</button>
        </div>
        <div class="form-control">Name</div>
      </div>
      <div
        class="active-pink-3 active-pink-4 mb-1"
        style="margin-left: 10px;max-width: 100%; float: left;"
      >
        <!-- <input class="form-control" type="text" placeholder="Search" aria-label="Search"> -->
        <b-button pill variant="info">Button</b-button>
      </div>
    </div>
    <div class="col-12">
      <div class="row">
        <!-- <div class="col"></div> -->
        <div class="col-2 text-center">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <p class="my-0 font-weight-normal">発注日</p>
            </div>
            <div class="card-body p-0 d-flex flex-column justify-content-between">
              <div>
                <div class="form-group mb-0 form-control">2020-07-02</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-2 text-center">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <p class="my-0 font-weight-normal">納品日</p>
            </div>
            <div class="card-body p-0 d-flex flex-column justify-content-between">
              <div>
                <div class="form-group mb-0 form-control">2020-07-02</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-2 text-center">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <p class="my-0 font-weight-normal">Canvas name</p>
            </div>
            <div class="card-body p-0 d-flex flex-column justify-content-between">
              <div>
                <div class="form-group mb-0">
                  <multiselect
                    v-model="canvasSelectedName"
                    :options="allName"
                    :searchable="true"
                    :close-on-select="true"
                    :show-labels="false"
                    placeholder="Canvas name"
                    label="canvas_name"
                    track-by="cmn_pdf_canvas_id"
                    @select="showCanvasBg($event)"
                  ></multiselect>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col"></div>
      </div>
    </div>
    <div class="col-12">
      <b-button variant="danger" style="margin-left: 1px;" @click="deleteObjects()">Delete</b-button>
      <b-button variant="primary" @click="printCanvas">Print</b-button>
      <!-- <input class="btn btn-info" @change="bgImageChange" type="file" /> -->
      <b-button variant="warning" @click="clearCanvasObjects">Clear canvas</b-button>
      <br />
      <canvas
        id="c"
        style="border:1px solid #000000;"
      >Your browser does not support the canvas element.</canvas>
    </div>
    <div class="col-12 text-center">
      <b-icon icon="caret-left" variant="info" font-scale="3" role="button" v-if="canvasDataLength>1"></b-icon>
      <b-icon icon="caret-right" variant="info" font-scale="3" role="button" v-if="canvasDataLength>1"></b-icon>
    </div>
    
  </div>
  <!-- <div class="row"> -->

  <!-- </div> -->
</template>

<script>
export default {
  data() {
    return {
      allName: [],
      canvasSelectedName: [],
      canvasDataLength:0,
      canvas: null,
      bg_image_path: null,
      canvas_name: null,
      canvas_id: null,
      byr_order_id: null,
      canvas_width: 1219,
      canvas_height: 510,
      pointerX: 100,
      pointerY: 50,
    };
  },
  methods: {
    loadCanvasData() {
      axios
        .post(this.BASE_URL + "api/load_canvas_data", {
          byr_order_id: this.byr_order_id,
        })
        .then(({ data }) => {
          this.allName = data.canvas_data;
          // console.log(data);
          // console.log(data.can_info);
          var canvas_info=data.can_info
          this.canvasDataLength=canvas_info.length;
          if (this.canvasDataLength!=0) {
            
          }
          // this.canvasAllData=data.canvas_info;
          // createReactObj(originX='left',originY="top",left=100,top=50,width=150,height=22,text="Created by default",createdBy='auto')
          
        })
        .catch(() => {
          this.sweet_advance_alert();
        });
    },
    showCanvasBg($event) {
      this.bg_image_path = this.BASE_URL + "public/backend/images/canvas/Background/"+$event.canvas_bg_image;
      this.backgroundImageSet(this.bg_image_path);
    },
    canvasDataView(text_data) {
      var c = this.canvas;
      c.loadFromJSON(text_data, function () {
        c.renderAll();
      });
    },
    deleteObjects() {
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
    canvasClear() {
      var obj = this.canvas.getObjects();
      this.canvas.remove(obj);
    },
    canvasFieldClead() {
      this.canvas_name = null;
      this.canvas_id = null;
      this.submit_button = "Save";
      this.update_image_info = null;
      this.bg_image_path =
        this.BASE_URL + "public/backend/images/canvas/Background/bg_image.jpg";
      this.backgroundImageSet(this.bg_image_path);
    },
    bgImageProcess(bg_image) {
      var img = new Image();
      var mainCanvas = this.canvas;
      img.onload = function () {
        var f_img = new fabric.Image(img);
        mainCanvas.setBackgroundImage(
          f_img,
          mainCanvas.renderAll.bind(mainCanvas),
          {
            // width: mainCanvas.width,
            // height: mainCanvas.height,
            originX: "left",
            originY: "top",
          }
        );
        mainCanvas.setWidth(img.width);
        mainCanvas.setHeight(img.height);
      };
      img.src = bg_image;
    },
    clearCanvasObjects() {
      this.canvas.clear();
      this.canvasFieldClead();
    },
    printCanvas() {
      this.deselectObject();
      this.printData(".canvas-container");
    },
    deselectObject() {
      var canvas = this.canvas;
      var activeObjects = canvas.getActiveObjects();
      if (activeObjects.length) {
        // if (confirm('Do you want to delete the selected item??')) {
        activeObjects.forEach(function (object) {
          canvas.discardActiveObject(object);
          canvas.renderAll();
        });
        // }
      }
    },
    printData(divVar) {
      var canvas = this.canvas;
      var thisVar = this;
      var imgSrc = canvas.backgroundImage._element.src;
      canvas.backgroundImage = 0;
      canvas.renderAll();
      var ppp = $(divVar).printThis({
        debug: false, // show the iframe for debugging
        importCSS: false, // import parent page css
        importStyle: false, // import style tags
        printContainer: true, // print outer container/$.selector
        loadCSS: Globals.base_url + "/public/css/pdf_css.css", // path to additional css file - use an array [] for multiple
        pageTitle: "0", // add title to print page
        removeInline: false, // remove inline styles from print elements
        removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline must be true
        printDelay: 500, // variable print delay EX: 333
        header: null, // prefix to html or null
        footer: null, // postfix to html or null
        base: false, // preserve the BASE tag or accept a string for the URL
        formValues: true, // preserve input/form values
        canvas: true, // copy canvas content
        doctypeString: "", // enter a different doctype for older markup
        removeScripts: false, // remove script tags from print content
        copyTagClasses: false, // copy classes from the html & body tag
        beforePrintEvent: null, // function for printEvent in iframe
        beforePrint: null, // function called before iframe is filled
        afterPrint: null, // function called before iframe is removed
      });
      // console.log(ppp);
      setTimeout(function () {
        thisVar.backgroundImageSet(imgSrc);
      }, 510);
    },
    
    createReactObj(originX='left',originY="top",left=100,top=50,width=150,height=22,text="Created by default",createdBy='auto') {
      var activeObject = this.canvas.getActiveObject();
      var text_data = [
        {
          originX: originX,
          originY: originY,
          left: left,
          // left: this.pointerX - 50,
          // top: this.pointerY,
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
          scaleX: 1,
          scaleY: 1,
          angle: 0,
          flipX: 0, //false
          flipY: 0, //false
          opacity: 1,
          shadow: null,
          visible: 1, //true
          clipTo: null,
          backgroundColor: "",
          fillRule: "nonzero",
          paintFirst: "fill",
          globalCompositeOperation: "source-over",
          transformMatrix: null,
          skewX: 0,
          skewY: 0,
          text: text,
          fontSize: 20,
          fontWeight: "normal",
          fontFamily: "Times New Roman", //Arial, Times New Roman, Helvetica, sans-serif
          fontStyle: "normal",
          lineHeight: 1.16,
          underline: 0, //False
          overline: 0, //False
          linethrough: 0, //False
          textAlign: "left",
          textBackgroundColor: "",
          charSpacing: 0,
          minWidth: 20,
          splitByGrapheme: 0, //False
          objectCaching: false,
        },
      ];
        if (createdBy!='auto') {
          if (!activeObject) {
            this.addText(text_data);
          }
        }else{
          this.addText(text_data); 
        }
    },
    addText(text_data) {
      for (let i = 0; i < text_data.length; i++) {
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
          fontFamily: text_data[i]["fontFamily"], //Arial, Times New Roman, Helvetica, sans-serif
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
          objectCaching: false,
          // hasControls: false,
        });
        this.canvas.add(oText).setActiveObject(oText);
        this.canvas.renderAll();
      }
    },
    doubleClick(option) {
      // console.log(option);
      this.pointerX = option.pointer.x;
      this.pointerY = option.pointer.y;
      this.createReactObj('left',"top",this.pointerX-50,this.pointerY,150,22,"Created by Click",'clicked');
    },
    getCanvasBgImage() {
      var can_image = this.canvas.toDataURL({
        format: "png",
        quality: 0.8,
      });
      return can_image;
    },
    canvasData() {
      return this.canvas.toJSON();
    },
    backgroundImageSet(imgUrl) {
      var mainCanvas = this.canvas;
      this.canvas.setBackgroundImage(
        imgUrl,
        this.canvas.renderAll.bind(this.canvas),
        {
          // Optionally add an opacity lvl to the image
          backgroundImageOpacity: 0,
          // should the image be resized to fit the container?
          backgroundImageStretch: false,
          // image size as canvas size
          // width: this.canvas.width,
          // height: this.canvas.height
        }
      );
      // canvas size by image size
      this.bgImageWH(imgUrl);
    },
    bgImageWH(imgUrl) {
      var mainCanvas = this.canvas;
      const img = new Image();
      img.src = imgUrl;
      img.onload = function () {
        mainCanvas.setWidth(img.naturalWidth);
        mainCanvas.setHeight(img.naturalHeight);
      };
    },
    
    // }
  },
  created() {
    // this.canvasOpen();
  },
  mounted() {
    this.byr_order_id = this.$route.params.byr_order_id;
    this.canvas = new fabric.Canvas("c");
    this.canvas.setWidth(this.canvas_width);
    this.canvas.setHeight(this.canvas_height);
    // this.canvas.controlsAboveOverlay = true;
    this.bg_image_path = this.BASE_URL + "public/backend/images/canvas/Background/bg_image.jpg";
    this.backgroundImageSet(this.bg_image_path);
    // initAligningGuidelines(this.canvas);
    // initCenteringGuidelines(this.canvas);
    this.loadCanvasData();
    this.canvas.on("mouse:dblclick", (e) => {
      this.doubleClick(e);
    });
  },
};
</script>

<style>
</style>