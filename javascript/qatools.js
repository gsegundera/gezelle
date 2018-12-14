var skin ="";
var account = "";
var site = "";
var directory = "/_showcase";
var ids = "";
var url = window.location.origin;
var testdata1 = "";
var folder = "";
var TCFendPoint = "";
var PCFendPoint = "";
var path = "/_showcase/createpages";
var submit = "Create";

function create_folder(name="/_showcase") {
	var ep = "/files/new_folder?";
	return url + ep + ids + "&path=" + path + "&name=" + name;
}

function create_page(name, req) {

	var ep = "/templates/new?";
	var submit = "Create";				
	return url + ep + ids  + req;
}

function siteInfo(){	
	var option = "/sites/view?";
	return url + option + ids;

}

function fileView(file='/index.pcf') {	
	var option = "/files/view?";
	return url + option +  ids + "&path=" + file;
}

function getTCFInfo(path = "/_resources/ou/templates") {
	var ep = "/templates/list?";
	TCFendPoint = ep;
	var q = ids + "&path=" + path;
	var address = url + ep + q;
	return address;
}

function getTCFProperties(template, path = "/_resources/ou/templates") {
	var ep = "/templates/view?";
	TCFendPoint = ep;
	var q = ids + "&path=" + path + "&template=" + template;
	var address = url + ep + q;
	return address;
}

//create Pages from templates

function generateTCFList(data) {
	var tcfList =[];
	$.each(data.templates, function(k, v) {
		tcfList.push(v.name);					
	});	


	return tcfList;
}


function storeTCFList(data, fileName) {
	var text =[];
	$.each(data.fields, function (k, v) {					

		if ((v.prompt==="Directory Name") || (v.prompt==="Filename") || (v.prompt==="Folder Name"))  {
			text.push("&tcf_value_"+k+"=" + fileName.replace(".tcf", ""));

		} 

		else if (v.type==="filename") {
			text.push("&tcf_value_"+k+"=" + fileName.replace(".tcf", "") + ".inc");

		}	
		else if (v.type==="text") {
			text.push("&tcf_value_"+k+"=" + testdata1);

		}	
		else if (v.type==="select") {
			text.push("&tcf_value_"+k+"="+ v.options[0].value);

		}
		else if (v.type==="textarea") {
			text.push("&tcf_value_"+k+"=" + testdata1);

		}
		else if (v.type==="overwrite") {
			text.push("&tcf_value_"+k+"=true");
		}
		else if (v.type==="group") {
			text.push("&tcf_value_"+k+"=Everyone");
		}

	});


	var req="";

	$.each(text, function (k, v) {	
		req += v ;

	});

	return (req);

}	


function createPagesMaster() {
	$.get(getTCFInfo(path), function (data) {			
		var temp = "";
		$.each(generateTCFList(data), function (k, v) {		

			$.get(getTCFProperties(v, path), function (data)  {	
				temp = "&path=" + path + "/" + folder + "&submit=" + submit +  storeTCFList(data, v) + "&template=" + v;

				$.post(create_page(v, temp), function (data) {

				})

					.done(function() {
					$('#debugDiv').append('<p> Page from template ' + v + ' was successfully created!  </p>');
				})

					.fail(function(response) {

					$('#debugDiv').append('<p> Error: ' + response.responseText  + '</p><p>Page from template ' + v + ' was not created!  </p>');
				});

			});

		});

		

	});
}

$('#goButton1').on('click', function () {
$('#debugDiv').html("");
	if ($("input[id='createpage']").val().length != 0) {
		path = $("input[id='createpage']").val();
		testdata1 = $("#testdata option:selected").val();	
		folder = $("#testdata option:selected").text();
		
		var createFolder = function () {						
			var def = $.Deferred();						
			$.post(create_folder(folder), function (data) {
				
			})
			
			.fail(function(response) {
			$('#debugDiv').append('Error: ' + response.responseText );
		});
			
			setTimeout(function () {							
				def.resolve();
			}, 2000);

			return def;
		};


		var tcfPages = function () {
			createPagesMaster();
		};

		createFolder().done(tcfPages);
	}		
	
	else {
		alert ("please provide a valid path");

	}

});

//end of create pages from templates

//create QA Test Form
function create_asset(name) {
	var ids = "&skin=" + skin + "&account=" + account + "&site=" + site;
	var option = "/assets/new?";	
	var description = "QA Test Form";
	var email = "[{\"to\":\"gsegundera@omniupdate.com\",\"from\":\"no-reply@omniupdate.com\",\"subject\":\"Form Test Submission\",\"body\":\"This is a test:\\nEmail Address: {{name}}\",\"include_all\":true}]";	
	var elements = "[{\"name\":\"name\",\"type\":\"input-text\",\"format\":null,\"required\":true,\"label\":\"Email Address\",\"default\":\"\",\"validation\":\"email\",\"validation_fail\":\"Please provide a valid email 		address\",\"advanced\":\"addclass=qatest;\\nsize=20;\",\"elementInfo\":\"Single-Line Text Field Helper Texr\",\"options\":[]},{\"name\":\"multilinetextfield\",\"type\":\"textarea\",\"format\":null,\"required\":true,\"label\":\"Multi-Line Text Field\",\"default\":\"\",\"validation\":\"minlength:5\",\"validation_fail\":\"Please provide at least 5 characters\",\"advanced\":\"addclass=qatest;\\nrows=15;\\ncols=20;\",\"elementInfo\":\"This is Multi-Line Text Field Helper Text\",\"options\":[]},{\"name\":\"radiobuttons\",\"type\":\"input-radio\",\"format\":null,\"required\":true,\"label\":\"Radio Buttons\",\"default\":\"\",\"validation\":\"\",\"validation_fail\":\"This field is required.\",\"advanced\":\"fieldset_label=Choices;\\nfieldset_start=true;\",\"elementInfo\":\"Radio Buttons Helper Text\",\"options\":[{\"value\":\"Yes\",\"selected\":false,\"text\":\"Yes\"},{\"value\":\"No\",\"selected\":false,\"text\":\"No\"},{\"value\":\"Maybe\",\"selected\":false,\"text\":\"Maybe\"}]},{\"name\":\"checkboxes\",\"type\":\"input-checkbox\",\"format\":null,\"required\":true,\"label\":\"Checkboxes\",\"default\":\"\",\"validation\":\"\",\"validation_fail\":\"This field is required.\",\"advanced\":\"fieldset_end=true;\",\"elementInfo\":\"Checkboxes Helper Text\",\"options\":[{\"value\":\"Pants\",\"selected\":false,\"text\":\"Pants\"},{\"value\":\"Shirt\",\"selected\":false,\"text\":\"Shirt\"},{\"value\":\"Shorts\",\"selected\":false,\"text\":\"Shorts\"}]},{\"name\":\"dropdown\",\"type\":\"select-single\",\"format\":null,\"required\":true,\"label\":\"State\",\"default\":\"\",\"validation\":\"\",\"validation_fail\":\"This field is required.\",\"advanced\":\"class=qatest;\\ndataset=state;\",\"elementInfo\":\"Drop-Down Helper Text\",\"options\":[]},{\"name\":\"multiselect\",\"type\":\"select-multiple\",\"format\":null,\"required\":true,\"label\":\"Multi-Select\",\"default\":\"\",\"validation\":\"\",\"validation_fail\":\"This field is required.\",\"advanced\":\"class=qatest;\",\"elementInfo\":\"Multi-Select Helper Text\",\"options\":[{\"value\":\"One\",\"selected\":false,\"text\":\"One\"},{\"value\":\"Two\",\"selected\":false,\"text\":\"Two\"},{\"value\":\"Three\",\"selected\":false,\"text\":\"Three\"}]},{\"name\":\"dateandtime\",\"type\":\"datetime\",\"format\":\"datetime\",\"required\":true,\"label\":\"Date and Time\",\"default\":\"08/30/2018 03:45 PM\",\"validation\":\"datetime\",\"validation_fail\":\"This field is required.\",\"advanced\":\"class=qatest;\",\"elementInfo\":\"Date and Time Helper Text\",\"options\":[]},{\"name\":\"insttext8\",\"type\":\"insttext\",\"format\":null,\"required\":false,\"label\":\"Instructional Text\",\"default\":\"\",\"validation\":\"\",\"validation_fail\":\"\",\"advanced\":\"class=qatest;\",\"elementInfo\":\"\",\"options\":[]}]";

	var req = "&name=" + name + "&description=" + description + "&site_locked=true&url_redirect_filechooser=&use_database=true&group=Everyone&readers=Everyone&elements=" + elements + "&emails=" + email + "&type=4&pass_message=test&fail_message=fail&url_redirect=false&url_redirect_path=&submit_text=test+submit&form_advanced=&tags=";
	return url + option + ids + req;
}

$('#goButton2').on('click', function () {	

	if ($("input[id='form_name']").val().length != 0) {
		formName = $("input[id='form_name']").val();

		$.post(create_asset(formName), function (data) {
			alert("Your form was successfully  created!");

		});	
	}
	else {
		alert ("Please provide a valid form name");
	}


});

//end Create QA Test Form

//create file list for Greg's Tool

function fileHttpPath(data) {		
	var fileList = [];
	var dirList = [];
	$.each(data.entries, function (k, v) {


		if ((v.staging_path.endsWith('pcf')) && !(v.staging_path.includes('_props'))) {
			fileList.push(v.staging_path);
		}
		else if (v.is_directory === true){
			dirList.push(v.remote_path);
		}
	});

	//getFileDetails(fileList);
	$.when(fileList).done(function(){
		$.each(fileList, function (k, v) {

			$.get(fileView(v), function(data) {
				outputData(data.info.http_path);

			});
		});
	});

	$.when(dirList).done(function(){
		$.each(dirList, function (k, v) {			
			$.get(getPCFInfo(v), function(data) {
				fileHttpPath(data);	
			});			
		});
	});

}


function fileListData(data) {
	var fileList = [];
	var dirList =[];
	$.each(data.entries, function (k, v) {
		if ((v.http_path.endsWith('pcf')) && !(v.http_path.includes('_props'))) {
			fileList.push(v.http_path);
		}

		else if (v.is_directory === true){
			dirList.push(v.remote_path);
		}
	});

}



//Start
$('#goButton3').on('click', function () {

	if ($("input[id='directory']").val().length != 0) {
		directory = $("input[id='directory']").val();

		$.get(getPCFInfo(directory), function (data) {
			fileHttpPath(data);

			//fileListData(data);
		});

		$.get(siteInfo(), function(data) {		
			//console.log("domain:" + data.http_root);
			domain = data.http_root;
		});



		$.get(getPCFInfo(directory), function (data) {		
			$.get(fileView(dirListData(data)), function(data) {
				extensionOut = data.info.remote_path.split(".").pop();


			});

		});

		$('#csv-start').one('click', function () { 
			$('#csv-start').prepend(document.createTextNode("<ul>\r"));
			$('#csv-start').append(document.createTextNode("</ul>"));
		});		

	}

	else {
		alert ("Please provide a valid path!");
	}

});

$('#copyTextButton').on('click', function () {

	var copyText = document.getElementById("csv-start");

	/* Select the text field */
	copyText.select();

	/* Copy the text inside the text field */
	document.execCommand("copy");

	/* Alert the copied text */
	alert("Copied the text: ");
} );

$('#clearTextButton').on('click', function () {
	$('#csv-start').empty();
} );





//end file list for Greg's Tool



//Display function based on output type
function displayType(displayType, data, index) {
	var output = "";
	switch (displayType) {
		case 'text':
		case 'textarea':
			output += textDisplay();
			break;
		case 'select':
		case 'radio':
			output += selectOrRadioDisplay(data, index);
			break;
		case 'checkbox':
			output += checkboxDisplay(data, index);
			break;
		case 'filechooser':
		case 'asset':
		case 'tag':
		case 'image':
		case 'overwrite':
		case 'filename':
		case 'group':
		case 'datetime':
		case 'date':
		case 'time':
			output += chooserDisplay();
			break;
	}
	return output;
}

//Display type options
function textDisplay() {
	var output = "";
	var textData = {
		value1: "abcdefghijklmnopqrstuvwxyz",
		value2: "<>?:{}|!@#$%\,^&*()_+[]\;",
		value3: "Blank TEXT"
	};
	output += textData.value1 + "<tr><td></td><td></td><td></td><td>" + textData.value2 + "</td></tr><tr><td></td><td></td><td></td><td>" + textData.value3 + "</td></tr><td></td>";
	return output;
}

function selectOrRadioDisplay(data, index) {
	var output = "";

	if (TCFendPoint.includes('/templates/view?')) {
		for (var item in data[index].options) {
			var selectOrRadioType = {
				option: data[index].options[item].text
			};            
			output += selectOrRadioType.option + "<tr><td></td><td></td><td></td><td>";
		}
	}

	if (PCFendPoint.includes('/files/properties?')) {
		for (var item in data[index].options) {
			var selectOrRadioType = {
				option: data[index].options[item].option
			};
			output += selectOrRadioType.option + "<tr><td></td><td></td><td></td><td>" ;
		}
	}

	if (PCFendPoint.includes('/files/multiedit?')) {
		for (var item in data[index].options) {
			var selectOrRadioType = {
				option: data[index].options[item].label
			};
			output += selectOrRadioType.option + "<tr><td></td><td></td><td></td><td>";
		}
	}

	output += "</td></tr><td></td>";

	return output;
}

function chooserDisplay() {
	var output = "";
	var chooserType = {
		value: "*value*"
	};
	output +=  chooserType.value + "<tr><td></td><td></td><td></td><td>";    
	output += "</td></tr><td></td>";
	return output;
}

function checkboxDisplay(data, index) {
	var output = "";

	if (TCFendPoint.includes('/templates/view?')) {
		for (var item in data[index].options) {
			var checkboxType = {
				option: data[index].options[item].selected
			};
			//output += checkboxType.option + "\r\t\t\t";
			output += checkboxType.option + "<tr><td></td><td></td><td></td><td>";
		}
	}

	if (PCFendPoint.includes('/files/properties?')) {
		for (var item in data[index].options) {
			var checkboxType = {
				option: data[index].options[item].option
			};
			output +=  checkboxType.option + "<tr><td></td><td></td><td></td><td>";
		}
	}

	if (PCFendPoint.includes('/files/multiedit?')) {
		for (var item in data[index].options) {
			var checkboxType = {
				option: data[index].options[item].selected
			};
			output += checkboxType.option + "<tr><td></td><td></td><td></td><td>";
		}
	}

	output += "</td></tr><td></td>";

	return output;
}


// TCF ####################################################################################

//TODO: Parameter for value from html text box.
var tcfPath = "";


var getTCFFileList = function (path) {
	$.get(getTCFInfo(path)).done(function (response) {
		proccessTCFList(response);
	});

	function proccessTCFList(data) {
		var filenames = [];
		for (var item in data.templates) {
			filenames.push(data.templates[item].name);
		}
		getProperties(filenames);
	}

	function getProperties(filenames) {
		for (var file in filenames) {
			var url = getTCFProperties(filenames[file], path);
			$.get(url).done(function (response) {
				displayOut(response);
			});
		}
	}

	//Specific display for /files/list endpoint
	function displayOut(fileData) {
		output = "<tr><td>";
		output += fileData.title + "</td>"; //1
		for (var item in fileData.fields) {
			output += "<td>" + fileData.fields[item].prompt + "</td>"; //2
			output += "<td>" + fileData.fields[item].type + "</td>"; //3
			output += "<td>" + displayType(fileData.fields[item].type, fileData.fields, item) + "</td>";
		}
		output += "</tr>";
		$('#tcf-start').append(output);
	}
};
// TCF ####################################################################################

// PCF ####################################################################################
function getPCFInfo(path = "/_showcase") {
	var ep = "/files/list?";
	//PCFendPoint = ep;
	var q = ids + "&path=" + path;
	var address = url + ep + q;
	return address;
}

function getPCFProperties(path) {
	var ep = "/files/properties?";
	PCFendPoint = ep;
	TCFendPoint = "";
	var q = ids + "&path=" + path;
	var address = url + ep + q;
	return address;
}


var getPCFFileList = function (path) {
	$.get(getPCFInfo(path)).done(function (response) {
		proccessPCFList(response);
	});

	function proccessPCFList(data) {
		var filenames = [];
		var dirList = [];

		$.each(data.entries, function(k, v) {		
			if (v.staging_path.endsWith('pcf')) {
				filenames.push(v.staging_path);
			}

			else if (v.is_directory === true){
				dirList.push(v.staging_path);
			}
		});
		getProperties(filenames);

		$.when(dirList).done(function(){
			$.each(dirList, function (k, v) {			
				$.get(getPCFInfo(v)).done(function (data) {
					proccessPCFList(data);
				});
			});			
		});
	}


	function getProperties(path) {
		$.each(path, function (i, v) {
			var url = getPCFProperties(v, path);
			$.get(url).done(function (response) {
				displayOut(response, v);
			});
		});
	}



	//Specific display for /files/list endpoint
	function displayOut(fileData, filename) {
		output = "<tr><td>";
		output += filename + "</td>"; //1        
		for (var item in fileData.parameters) {
			output +="<td>" +  fileData.parameters[item].name + "</td>"; //2
			output +="<td>" + fileData.parameters[item].type + "</td>"; //3
			output += "<td>" + displayType(fileData.parameters[item].type, fileData.parameters, item) + "</td>";
		}
		output += "</tr>";
		$('#pcf-start').append(output);
	}
};
// PCF ####################################################################################


// MULTIEDIT ##############################################################################
function getMultieditInfo(path = "/_showcase") {
	var ep = "/files/multiedit?";
	PCFendPoint = ep;
	var q = ids + "&path=" + path;
	var address = url + ep + q;
	return address;
}

var getMultieditList = function (path) {
	$.get(getPCFInfo(path)).done(function (response) {
		proccessPCFList(response);
	})

	function proccessPCFList(data) {
		var filenames = [];
		var dirList = [];

		$.each(data.entries, function(k, v) {		
			if (v.staging_path.endsWith('pcf')) {
				filenames.push(v.staging_path);
			}

			else if (v.is_directory === true){
				dirList.push(v.staging_path);
			}
		});

		getMultiedit(filenames);

		$.when(dirList).done(function(){
			$.each(dirList, function (k, v) {			
				$.get(getPCFInfo(v)).done(function (data) {
					proccessPCFList(data);
				});
			});			
		});
	}

	function getMultiedit(path) {
		$.each(path, function (i, v) {
			var url = getMultieditInfo(v, path);
			$.get(url).done(function (response) {
				displayOut(response, v);
			});
		});
	}

	function displayOut(fileData, filename) {
		output = "<tr><td>";
		output += filename + "</td>"; //1        
		for (var item in fileData.fields) {
			output += "<td>" +  fileData.fields[item].prompt + "</td>"; //2
			output += "<td>" + fileData.fields[item].type + "</td>"; //3
			output += "<td>" + displayType(fileData.fields[item].type, fileData.fields, item) + "</td>";
		}
		output += "</tr>";
		$('#multiedit-start').append(output);
	}
}
// MULTIEDIT ##############################################################################

//Set variable values on click.
function setSchool(){
	skin = $('#skin1').text();
	account = $('#account1').text();
	site = $('#site1').text();
	ids = "&skin=" + skin + "&account=" + account + "&site=" + site;
}


//start
$(document).ready(function(){
	//Pre-fill page with account information from URL.
	var pageUrl = window.parent.location.hash.split("/", 3);    
	$('#skin1').text(pageUrl.shift().slice(1));
	$('#account1').text(pageUrl.shift());
	$('#site1').text(pageUrl.shift());
	skin = $('#skin1').text();
	account = $('#account1').text();
	site = $('#site1').text();
	ids = "&skin=" + skin + "&account=" + account + "&site=" + site;	
});

//can start $when, then here.
$('#tcfPathButton').on('click', function () {	
	if ($("#tcfPath").val().length != 0) {
		let val = $('#tcfPath').val();
		$('#tcf-start').html('<tr><td data-style="bgcolor">Filename</td><td data-style="bgcolor">Option</td><td data-style="bgcolor">Type</td><td data-style="bgcolor">Value</td><td data-style="bgcolor">Pass</td><td data-style="bgcolor">Fail</td><td data-style="bgcolor">Comments</td><td data-style="bgcolor">Developer Comments</td></tr>');
		getTCFFileList(val);
	}
	else {
		alert ("Please provide a valid path!");
	}
});

$('#pcfPathButton').on('click', function () {

	if ($("#pcfPath").val().length != 0) {	
		let val = $('#pcfPath').val();
		$('#pcf-start').html('<tr><td data-style="bgcolor">Filename</td><td data-style="bgcolor">Option</td><td data-style="bgcolor">Type</td><td data-style="bgcolor">Value</td><td data-style="bgcolor">Pass</td><td data-style="bgcolor">Fail</td><td data-style="bgcolor">Comments</td><td data-style="bgcolor">Developer Comments</td></tr>');
		getPCFFileList(val);
	}
	else {
		alert ("Please provide a valid path!");
	}
});

$('#multieditPathButton').on('click', function () {
	if ($("#multieditPath").val().length != 0) {
		let val = $('#multieditPath').val();
		$('#multiedit-start').html('<tr><td data-style="bgcolor">Filename</td><td data-style="bgcolor">Option</td><td data-style="bgcolor">Type</td><td data-style="bgcolor">Value</td><td data-style="bgcolor">Pass</td><td data-style="bgcolor">Fail</td><td data-style="bgcolor">Comments</td><td data-style="bgcolor">Developer Comments</td></tr>');
		getMultieditList(val);
	}
	else {
		alert ("Please provide a valid path!");
	}
});

//Export to Excel script

var tablesToExcel = (function() {
	var uri = 'data:application/vnd.ms-excel;base64,'
	, tmplWorkbookXML = '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
	+ '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Gezelle Segundera</Author><Created>{created}</Created></DocumentProperties>'
	+ '<Styles>'
	+ '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>'
	+ '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>'
	+ ' <Style ss:ID="bgcolor"><Interior ss:Color="#00B0F0" ss:Pattern="Solid"></Interior></Style>'
	+ ' <Style ss:ID="s70"><Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/><Interior ss:Color="#FFC000" ss:Pattern="Solid"/></Style>'
	+ '</Styles>' 
	+ '{worksheets}</Workbook>'
	, tmplWorksheetXML = '<Worksheet ss:Name="{nameWS}"><Table>{rows}</Table></Worksheet>'
	, tmplCellXML = '<Cell{attributeStyleID}{attributeFormula}{merge}><Data ss:Type="{nameType}">{data}</Data></Cell>'
	, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
	, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	return function(tables, wsnames, wbname, appname) {
		var ctx = "";
		var workbookXML = "";
		var worksheetsXML = "";
		var rowsXML = "";

		for (var i = 0; i < tables.length; i++) {
			if (!tables[i].nodeType) tables[i] = document.getElementById(tables[i]);
			for (var j = 0; j < tables[i].rows.length; j++) {
				rowsXML += '<Row>'
				for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
					var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
					var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
					var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
					dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
					var dataFormula = tables[i].rows[j].cells[k].getAttribute("data-formula");
					var cellMerge = tables[i].rows[j].cells[k].getAttribute("data-merge");
					dataFormula = (dataFormula)?dataFormula:(appname=='Calc' && dataType=='DateTime')?dataValue:null;
					ctx = {  attributeStyleID: (dataStyle=='Currency' || dataStyle=='Date'|| dataStyle=='bgcolor' || dataStyle=='s70')?' ss:StyleID="'+dataStyle+'"':''
						   , nameType: (dataType=='Number' || dataType=='DateTime' || dataType=='Boolean' || dataType=='Error')?dataType:'String'
						   , data: (dataFormula)?'':dataValue
						   , attributeFormula: (dataFormula)?' ss:Formula="'+dataFormula+'"':''
						   , merge: (cellMerge)?' ss:MergeAcross="'+cellMerge+'"':''
						  };
					rowsXML += format(tmplCellXML, ctx);
				}
				rowsXML += '</Row>'
			}
			ctx = {rows: rowsXML, nameWS: wsnames[i] || 'Sheet' + i};
			worksheetsXML += format(tmplWorksheetXML, ctx);
			rowsXML = "";
		}

		ctx = {created: (new Date()).getTime(), worksheets: worksheetsXML};
		workbookXML = format(tmplWorkbookXML, ctx);

		//console.log(workbookXML);

		var link = document.createElement("A");
		link.href = uri + base64(workbookXML);
		link.download = wbname || 'Workbook.xls';
		link.target = '_blank';
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	}
})();	

$('#filenamebutton').on('click', function () {
	if ($("#filename").val().length != 0) {
		let filename = $('#filename').val();
		tablesToExcel(['summary','ui', 'responsive', 'w3c','pcf-start','multiedit-start', 'tcf-start'], ['SUMMARY','UI', 'Responsive','W3C and Access Errors','PCF', 'MultiEdit','TCF'], filename + '.xls', 'Excel');
	}

	else{
		alert ("Please provide a valid filename");
	}

});	





