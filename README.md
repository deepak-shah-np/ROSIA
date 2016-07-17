#ROSIA
=====

##ROSIA data visualization.
###Instruction
1. To run the project simply clone the project from github.<br>
    ``` $ git clone https://github.com/hello-deepak/ROSIA```
2. Install symfony2. Instructions to install symfony given below.

### Running
1. Run the server using.<br>
   ```$ php app/console server:run```
2. Open your browser and type "localhost:8000".


================================

## Symfony Installation Instructions

###Installation and Configuration
1. Download Symfony from:
    http://symfony.com/download#symfony1
2. Before installing symfony make sure that you have installed curl and composer.
3. Put the bootstrap folder and jquery file in web folder inside symfony framework.
4. Create a new bundle <br>
   ```$ php app/console generate:bundle --namespace=Rosia/ChartBundle --format=yml```
5. Replace the ChartBundle file inside src/Rosia with cloned chart bundle.
6. Make sure that the bundle is registered in app/AppKernel.php.
7. Put the rosia_data.json file in web folder inside the framework.
