<template>
<canvas id="c" style="border:1px solid #000000;">Your browser does not support the canvas element.</canvas>
  <!-- <canvas ref="can" id="canvas" width="1000" height="200" style="border:1px solid red">Can</canvas> -->
</template>

<script>
export default {
data(){
  return {
    vueCanvas:null,
    canvas : null,
    bg_image_path:null,
    pointerX:100,
    pointerY:50,
  }
},
methods:{
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
      createGraphics() {
        console.log(this.canvas);
            this.createReactObj();
          },
          createReactObj(){
            const rect = new fabric.Rect({
            left: this.pointerX,
            top: this.pointerY-100,
            fill: '#D81B60',
            width: 50,
            height: 50,
            strokeWidth: 2,
            stroke: "#880E4F",
            rx: 10,
            ry: 10,
            angle: 45,
            scaleX: 3,
            scaleY: 3,
            hasControls: true
          });
            this.canvas.add(rect);
          },
          doubleClick(option){
            console.log(option);
            this.pointerX=option.pointer.x
            this.pointerY=option.pointer.y
            this.createReactObj();
          },
        // }
      },
      created(){
        // this.canvasOpen();
      },
      mounted(){
        this.canvas = new fabric.Canvas("c");
          this.canvas.setWidth(1219);
          this.canvas.setHeight(510);
          this.canvas.controlsAboveOverlay = true;
          this.bg_image_path=this.BASE_URL + 'public/backend/images/canvas/Background/bg_image.jpg'
          this.backgroundImageSet(this.bg_image_path);
          // initAligningGuidelines(this.canvas);
          // initCenteringGuidelines(this.canvas);
          this.createGraphics();
          this.canvas.on('mouse:dblclick', (e) => {
            this.doubleClick(e)
          })
    }
}
</script>

<style>

</style>