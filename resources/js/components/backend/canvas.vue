<template>
<div class="row">
                <div class="col-12">
                    <h2 class="top_title text-center">Canvas</h2>
                </div>
    <!-- <div class="col-12" id="">
        <div class="card card-small mb-8">
            <div class="card-body p-0 pb-3">
                <button style="margin-left: 1px;" class="btn btn-danger" onclick="deleteObjects()">Delete</button>
                <button class="print-button btn btn-primary">Print</button>
                <input class="bg_image btn btn-info" type="file">
                <input type="hidden" value="" name="update_canvas_id" id="update_canvas_id">
                <input type="hidden" value="" name="update_image_info" id="update_image_info">
                <br>
                <br>
                <div class="row" style="margin-left: 1px;">
                        <input type="text" name="canvas_name" id="canvas_name" class="form-control" placeholder="Please enter canvas name" style="width:300px !important">
                        <a class="save_button btn btn-info" style="margin-left: 5px;" href="#">Save</a>
                    
                </div>
                <br>
                <canvas id="c">
                    Your browser does not support the canvas element.
                </canvas>
            </div>
        </div>
    </div>
<br> -->
                <div class="col-12">
                  <b-button variant="danger" style="margin-left: 1px;" @click="deleteObjects()">Delete</b-button>
                <b-button variant="primary" @click="printCanvas">Print</b-button>
                <input class="btn btn-info" @change="bgImageChange" type="file">
                <b-button variant="warning" @click="clearCanvasObjects">Clear canvas</b-button>
                <br>
                <br>
                <div class="row" style="margin-left: 1px;">
                        <input type="text" v-model="canvas_name" class="form-control" placeholder="Please enter canvas name" style="width:300px !important">
                        <b-button variant="info" style="margin-left: 5px;" @click="saveData">{{submit_button}}</b-button> 
                </div>
                <br>
                    <canvas id="c" style="border:1px solid #000000;">Your browser does not support the canvas element.</canvas>
                </div>
                <div class="col-12">
                  <!-- <div class="col"> -->
        <div class="card card-small mb-8" style="margin-top: 25px;">
            <div class="card-header border-bottom">
                <h6 class="m-0">Canvas List</h6>
            </div>
            <div class="card-body p-0 pb-3" id="canvasList">
                <table id="" class="table mb-0"> 
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Canvas Name</th>
                            <th>Image</th>
                            <th>Last Update</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                    <tbody>
                        <tr v-for="(canvasData,i) in canvasAllData" :key="i">
                          <td>{{(i+1)}}</td>
                          <td>{{canvasData.canvas_name}}</td>
                          <td><img :src="BASE_URL+'public/backend/images/canvas/Canvas_screenshoot/'+canvasData.canvas_image" alt="No image" class="img-responsive img-thumbnail" width="150" height="100" style="border: 1px solid gray;"></td>
                          <td v-html="formatDate(canvasData.updated_at)"></td>
                          <td>
                            <b-button variant="info" @click="editCanvas(canvasData)"><b-icon icon="pencil-square" font-scale="1.2"></b-icon></b-button>
                            <b-button variant="danger" @click="deleteCanvas(canvasData.cmn_pdf_canvas_id)"><b-icon icon="trash-fill" font-scale="1.2"></b-icon></b-button>
                          </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <!-- </div> -->
                </div>
</div>
<!-- <div class="row"> -->

    
<!-- </div> -->
</template>

<script>
export default {
data(){
  return {
    canvasAllData:[],
    canvas : null,
    bg_image_path:null,
    canvas_name:null,
    canvas_id:null,
    update_image_info:null,
    byr_id:null,
    submit_button:'Save',
    pointerX:100,
    pointerY:50,
  }
},
methods:{
          formatDate(date_string) {
            var date = new Date(date_string)
              return date.getFullYear() + '-' +
                  this.length_fill(date.getMonth() + 1) + '-' +
                  this.length_fill(date.getDate()) + ' ' +
                  this.length_fill(date.getHours()) + ':' +
                  this.length_fill(date.getMinutes()) + ':' +
                  this.length_fill(date.getSeconds());
          },

          length_fill(data_string) {
              var strlenth = data_string.toString().length;
              var str;
              if (strlenth < 2) {
                  str = "0" + data_string;
              } else {
                  str = data_string;
              }
              return str;
          },
          loadCanvasData() {
            axios.post(this.BASE_URL+"api/load_canvas_data",{byr_buyer_id:this.byr_id})
                .then(({ data }) => {
                  this.canvasAllData=data.canvas_info;
                    // console.log(data);
                })
                .catch(() => {
                this.sweet_advance_alert();
                });
          },
          editCanvas(canvasData){
            // this.canvas.clear();
            this.canvasClear();
            this.canvas_name=canvasData.canvas_name;
            this.canvas_id=canvasData.cmn_pdf_canvas_id;
            this.submit_button='Update'
            this.bg_image_path=this.BASE_URL + 'public/backend/images/canvas/Background/'+canvasData.canvas_bg_image;
            this.backgroundImageSet(this.bg_image_path);
            $("html, body").animate({ scrollTop: 0 }, "slow");
            this.canvasDataView(canvasData.canvas_objects);
          },
          canvasDataView(text_data) {
            var c= this.canvas;
              c.loadFromJSON(text_data, function() {
              c.renderAll();
              });
          },
          deleteObjects(){
            var canvas=this.canvas;
            var activeObjects = canvas.getActiveObjects();
            if (activeObjects.length) {
                if (confirm('Do you want to delete the selected item??')) {
                    activeObjects.forEach(function(object) {
                        canvas.remove(object);
                    });
                }
            } else {
                alert('Please select the drawing to delete')
            }
          },
          deleteCanvas(cmn_pdf_canvas_id){
              this.init();
              this.delete_sweet().then((result) => {     
              if (result.value) { 
                //Send Request to server
                axios.post(this.BASE_URL+'api/delete_canvas',{cmn_pdf_canvas_id:cmn_pdf_canvas_id})
                    .then(({data})=> {
                      if (data.message=='success') {
                        this.alert_text="Canvas deleted"
                      }else if(data.message=='faild'){
                        this.alert_text="Canvas not deleted"
                      }
                      this.alert_icon=data.class_name
                      this.alert_title=data.title
                      this.sweet_normal_alert();
                      this.loadCanvasData()
                    }).catch(() => {
                        this.sweet_advance_alert();
                    })
                }

            })
            },
          bgImageChange(e) {
              let file = e.target.files[0];
              let reader = new FileReader();  
              if(file.size < 2111775){
                  if (file.type =="image/png" ||file.type =="image/jpeg") {
                    var mainThis=this;
                     reader.onload = function(e) {
                          var base64_var = e.target.result;
                          mainThis.bgImageProcess(base64_var);
                          mainThis.update_image_info=1;
                      };
                      reader.readAsDataURL(file);
                      reader.onerror = function() {
                          console.log('there are some problems');
                      };
                  }else{
                      this.alert_text='File must me jpg or png'
                      this.alert_title="Warning!",
                      this.alert_icon="warning"
                      this.sweet_normal_alert();
                      $('#image').val('');
                  }
              }else{
                  this.alert_text='File size can not be bigger than 2 MB'
                  this.alert_title="Warning!",
                  this.alert_icon="warning"
                  this.sweet_normal_alert();
                $('#image').val('');
              }
          //   this.form.image_url = URL.createObjectURL(file);
          },
          canvasClear(){
            var obj = this.canvas.getObjects();
            this.canvas.remove(obj)
          },
          canvasFieldClead(){
            this.canvas_name=null;
            this.canvas_id=null;
            this.submit_button='Save'
            this.update_image_info=null
            this.bg_image_path=this.BASE_URL + 'public/backend/images/canvas/Background/bg_image.jpg'
            this.backgroundImageSet(this.bg_image_path);
          },
          bgImageProcess(bg_image) {
              var img = new Image();
              var mainCanvas=this.canvas;
              img.onload = function() {
                  var f_img = new fabric.Image(img);
                  mainCanvas.setBackgroundImage(f_img, mainCanvas.renderAll.bind(mainCanvas), {
                      width: mainCanvas.width,
                      height: mainCanvas.height,
                      originX: 'left',
                      originY: 'top'
                  });
              };
              img.src = bg_image;
          },
          clearCanvasObjects(){
            this.canvas.clear();
            this.canvasFieldClead();
          },
          printCanvas(){
            this.deselectObject()
            this.printData('.canvas-container');
          },
          deselectObject(){
            var canvas= this.canvas;
            var activeObjects = canvas.getActiveObjects();
            if (activeObjects.length) {
                // if (confirm('Do you want to delete the selected item??')) {
                activeObjects.forEach(function(object) {
                    canvas.discardActiveObject(object);
                    canvas.renderAll();
                });
                // }
            }
          },
          printData(divVar) {
            var canvas=this.canvas;
            var thisVar=this;
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
                  doctypeString: '', // enter a different doctype for older markup
                  removeScripts: false, // remove script tags from print content
                  copyTagClasses: false, // copy classes from the html & body tag
                  beforePrintEvent: null, // function for printEvent in iframe
                  beforePrint: null, // function called before iframe is filled
                  afterPrint: null // function called before iframe is removed
              });
              // console.log(ppp);
              setTimeout(function() {
                  thisVar.backgroundImageSet(imgSrc);
              }, 510);


          },
          saveData(){
            if (this.canvas_name==null) {
                alert("Please fill canvas name");
                return false;
            }
            var canData = this.canvasData();
            if (!canData['objects'].length) {
                alert("No canvas drown");
                return false;
            }
            var canvas_data= { canvas_id: this.canvas_id, update_image_info: this.update_image_info,byr_id:this.byr_id, canvas_name: this.canvas_name, canData: canData, canvasImage: this.getCanvasBgImage() }
            axios.post(this.BASE_URL+"api/canvas_data_save",canvas_data)
                .then(({ data }) => {
                    if (data.message='created') {
                            this.alert_text="Canvas Created"
                        }else if(data.message='updated'){
                          this.alert_text="Canvas Updated"
                        }
                        this.alert_title=data.title
                        this.alert_icon=data.class_name
                        this.sweet_normal_alert();
                        this.loadCanvasData()
                        // this.canvasClear();
                        this.canvas.clear();
                        this.canvasFieldClead();
                })
                .catch(() => {
                this.sweet_advance_alert();
                });
        
          },
          createReactObj(){
            var activeObject = this.canvas.getActiveObject();
        var text_data = [{
            originX: "left",
            originY: "top",
            left: this.pointerX-50,
            top: this.pointerY,
            width: 150,
            height: 22,
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
            text: "Created by click",
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
        }];

        if (!activeObject) {
            this.addText(text_data);
            // addText(pageX, pageY, 150, 20, 'Created by click');
        }
          },
          doubleClick(option){
            // console.log(option);
            this.pointerX=option.pointer.x
            this.pointerY=option.pointer.y
            this.createReactObj();
          },
          getCanvasBgImage() {
              var can_image = this.canvas.toDataURL({
                  format: 'png',
                  quality: 0.8
              });
              return can_image;
          },
          canvasData() {
              return this.canvas.toJSON();
          },
          backgroundImageSet(imgUrl) {
        this.canvas.setBackgroundImage(imgUrl, this.canvas.renderAll.bind(this.canvas), {
            // Optionally add an opacity lvl to the image
            backgroundImageOpacity: 0,
            // should the image be resized to fit the container?
            backgroundImageStretch: false,
            width: this.canvas.width,
            height: this.canvas.height
        });
      },
      addText(text_data) {
    for (let i = 0; i < text_data.length; i++) {
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
            fontFamily: text_data[i]['fontFamily'], //Arial, Times New Roman, Helvetica, sans-serif
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
            objectCaching: false,
            // hasControls: false,
        });
        this.canvas.add(oText).setActiveObject(oText);
        this.canvas.renderAll();
    }
}
        // }
      },
      created(){
        // this.canvasOpen();
      },
      mounted(){
        this.byr_id = this.$route.params.byr_order_id;
        this.canvas = new fabric.Canvas("c");
          this.canvas.setWidth(1219);
          this.canvas.setHeight(510);
          // this.canvas.controlsAboveOverlay = true;
          this.bg_image_path=this.BASE_URL + 'public/backend/images/canvas/Background/bg_image.jpg'
          this.backgroundImageSet(this.bg_image_path);
          // initAligningGuidelines(this.canvas);
          // initCenteringGuidelines(this.canvas);
          this.loadCanvasData();
          this.canvas.on('mouse:dblclick', (e) => {
            this.doubleClick(e)
          })
    }
}
</script>

<style>

</style>