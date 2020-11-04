<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Essential Studio for JavaScript : TreeView - Multiple Drag and Drop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" />
    <link href="//cdn.syncfusion.com/14.4.0.15/js/web/flat-azure/ej.web.all.min.css" rel="stylesheet" />


    <script src="//cdn.syncfusion.com/js/assets/external/jquery-1.11.3.min.js" type="text/javascript"> </script>

    <script src="//cdn.syncfusion.com/js/assets/external/jquery.easing.1.3.min.js" type="text/javascript"></script>
    <script src="//cdn.syncfusion.com/14.4.0.15/js/web/ej.web.all.min.js" type="text/javascript"></script>
</head>
<body>
    <div class="content-container-fluid">
        <div class="row">
            <div class="cols-sample-area">
                <!--create the TreeView wrapper-->
				<table>
                  	<tr>
                      	<th>TreeView 1</th>
                      	<th>TreeView 2</th>
                  	</tr>
					<tr>
						<td>
							<div id="treeViewDrag"></div>
						</td>
						<td>
							<div id="treeViewDrop"></div>
						</td>
					</tr>
				</table>
            </div>
        </div>
    </div>
    <script>
		var tree1 = [

			{ id: 1, text: "Item 1" },
	
			{ id: 2, text: "Item 2" },
	
			{ id: 3, text: "Item 3" },
	
			{ id: 4, text: "Item 4" },
	
			{ id: 5, text: "Item 1.1" },
	
			{ id: 6, text: "Item 1.2" },
	
			{ id: 7, text: "Item 1.3" },
	
			{ id: 8, text: "Item 3.1" },
	
			{ id: 9, text: "Item 3.2" },
	
			{ id: 10, text: "Item 1.1.1" }
	
		];
	
		var tree2 = [
	
			{ id: 11, text: "Item 5" },
	
			{ id: 12, text: "Item 6" },
	
			{ id: 13, text: "Item 7" },
	
			{ id: 14, text: "Item 4" },
	
			{ id: 15, text: "Item 5.1" },
	
			{ id: 16, text: "Item 5.2" },
	
			{ id: 17, text: "Item 5.3" },
	
			{ id: 18, text: "Item 7.1" },
	
			{ id: 19, text: "Item 7.2" },
	
			{ id: 10, text: "Item 5.1.1" }
	
		];
	
		$(function () {
	
			// initialize and bind the TreeView with local data
	
			$("#treeViewDrag").ejTreeView({
	
				allowMultiSelection: true,
	
                allowDragAndDrop: true,
                
                allowDropChild: false,
	
				fields: { dataSource: tree1, id: "id", text: "text" , height: '115px'},
                
                nodeDropped: function(args) {
                    console.log(args);
                }
	
			});
	
			$("#treeViewDrop").ejTreeView({
	
				allowMultiSelection: true,
	
				allowDragAndDrop: true,
                
                allowDropChild: false,
	
                fields: { dataSource: tree2, id: "id", text: "text" },
                
                nodeDropped: function(args) {
                    console.log(args);
                }
	
			});
	
		}); 
    </script>
</body>
</html>

