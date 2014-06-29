<!DOCTYPE html>
<html lang="en">
    <head>
        <title>three.js webgl - loaders - OBJ MTL loader</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <link rel='stylesheet' href='css/webgl.css' />
        <script type="text/javascript" src="js/jquery.min.2-1-0.js"></script>
        <script type="text/javascript" src="js/simplesite.js"></script>
        <script src="js/three.min.js"></script>
        <script src="js/MTLLoader.js"></script>
        <script src="js/OBJLoader.js"></script>
        <script src="js/OBJMTLLoader.js"></script>
        <script src="js/Detector.js"></script>
    </head>

    <body>
        <div class="mainContainer">
            <!-- First up in the container is the heading section -->
            <div class="mainHeader">
                <!-- The title for the site -->
                <span class="mainTitle">Simple WebGL Viewer for IFC Files</span>
                <!-- The Logo for the simple site -->
            </div>
            <!-- Next up the menu area -->
            <div class="mainMenu" >
            </div>
            <!-- Next the viewing area -->
            <div class="mainView" id="mainView">
                
            </div>
            <!-- Finally the footer section -->
            <div class="mainFooter">
                <!-- The copyright information -->
                <span class="mainCopyright">&#169; 2014</span>
                <!-- The contact information -->
                <span class="mainContactInfo">Contact: EJK</span>
            </div>
        </div>

        <script>

            var container, stats;
            var camera, scene, renderer;
            var mouseX = 0;
            var mouseY = 0;
            var windowHalfX = window.innerWidth / 2;
            var windowHalfY = window.innerHeight / 2;

            init();
            animate();

            function init() {

                container = document.createElement('div');
                var div = document.getElementById('mainView');
                var divHeight = 500;
                var divWidth = 800;
                
                div.appendChild(container);

                camera = new THREE.PerspectiveCamera(100, window.innerWidth / window.innerHeight, 0.1, 100);
                camera.position.z = 45;

                // The scene

                scene = new THREE.Scene();
                var ambient = new THREE.AmbientLight(0xff0000);
                scene.add(ambient);

                var directionalLight = new THREE.DirectionalLight(0xffffff);
                directionalLight.position.set(200, 200, 100).normalize();
                scene.add(directionalLight);

                // The model

                var loader = new THREE.OBJMTLLoader();
                loader.load('img/house.obj', 'img/house.mtl', function(event) {
                    event.position.x = -10;
                    event.position.y = 0;
                    event.position.z = 0;
                    scene.add(event);

                });
                // The render 
                
                renderer = new THREE.WebGLRenderer({antialias: false});
                renderer.setSize(divWidth, divHeight);
                renderer.setClearColor(0x999999, 1);
                renderer.gammaInput = true;
                renderer.gammaOutput = true;
                renderer.shadowMapEnabled = true;
                renderer.shadowMapCullFace = THREE.CullFaceBack;
                container.appendChild(renderer.domElement);
                renderer.domElement.id = "webglCanvas";

                document.addEventListener('mousemove', onDocumentMouseMove, false);
                document.addEventListener('mousewheel', onMouseWheel, false);
                window.addEventListener('resize', onWindowResize, false);
                window.addEventListener('keydown', onKeyPress, false);

            }

            function onKeyPress(e) {
                var keynum;
                if (window.event) {
                    keynum = e.keyCode;
                } else {
                    keynum = e.which;
                }
                
                if (keynum == "38") {
                    camera.position.z = camera.position.z + 2;
                }
                
                if (keynum == "40") {
                    camera.position.z = camera.position.z - 2;
                }

            }

            function onMouseWheel(e) {
                var delta = 0;
                if (!e) {
                    event = window.event;
                } else if (event.wheelDelta) {
                    delta = event.wheelDelta/120;
                } else if (event.detail) {
                    delta = -event.detail/3;
                }
                
                if (delta == "-1") {
                    camera.position.z = camera.position.z + 2;
                }
                
                if (delta == "1") {
                    camera.position.z = camera.position.z - 2;
                }
                
            }

            function onWindowResize() {

                windowHalfX = window.innerWidth / 2;
                windowHalfY = window.innerHeight / 2;

                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                camera.fov *= zoomFactor;
                camera.updateProjectionMatrix();

                renderer.setSize(window.innerWidth, window.innerHeight);

            }

            function onDocumentMouseMove(event) {
                mouseX = (event.clientX - windowHalfX) / 10;
                mouseY = (event.clientY - windowHalfY) / 10;
            }

            //

            function animate() {
                requestAnimationFrame(animate);
                render();
            }

            function render() {
                camera.position.x += (mouseX - camera.position.x) * .5;
                camera.position.y += (-mouseY - camera.position.y) * .5;
                camera.lookAt(scene.position);
                renderer.render(scene, camera);
            }

        </script>

    </body>
</html>
