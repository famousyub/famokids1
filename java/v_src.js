new Vue({
  el: '#app',
  data: {
    greeting: 'Hello Vue!'
  }
})

Vue.component("hue-changer", {
  template: "#hue-changer",
  methods: {
    hueincrease: function () {
      this.$emit('hueincrease')
    }
  },
});

new Vue({
  el: '#app',
  data: {
    hue: 100
  },
  methods: {
    sethue(hsl) {
      this.hue += 10
    }
  }
})




var testApp = new Vue();

Vue.component("status-button-template", {
	template: "#vue-status-button-template",
	methods: {
		sendMessage: function() {
			testApp.$emit('messageSend', 'Message from Vue component 1');
		}
	}
});

Vue.component("status-overview", {
	template: "#vue-status-overview-template",
	data: function() {
		return {
			statusMessage: 'Init'
		}
	},
	methods: {
		displayMessage: function(message) {
			this.statusMessage = message;
		}
	},
	created: function() {
		testApp.$on('messageSend', this.displayMessage);
	}
});

new Vue({
	el: "#app"
});












// Listen Elements
var elmFile = document.getElementById('fileSelector');
var elmAdd = document.getElementById('add2DB');
var elmView = document.getElementById('viewDB');
var elmDeldb = document.getElementById('delDB');
// Add Listeners
elmFile.addEventListener('change', handleFileSelection, false);
elmAdd.addEventListener('click', handleAdd, false);
elmView.addEventListener('click', handleView, false);
elmDeldb.addEventListener('click', handleDeleteDB, false);

//Global Stores
var fileStore;
var imgStore;

// Misc Elements
var elmTitle = document.getElementById('title');
var elmArtist = document.getElementById('artist');
var elmImage = document.getElementById('img');
var elmAudio = document.getElementById('audio');
var elmPicture = document.getElementById('picture');
var elmTable = document.getElementById('display');

// Debug Element | xalert('message');
var elmMessages = document.getElementById('messages');
function xalert(message) {elmMessages.innerHTML += message + "<br>";}

// Delete Database
function handleDeleteDB(){
  db.delete();
  handleView();
  xalert("You'll need to refresh");
}

// Create Database
var db = new Dexie("visDB");
db.version(1).stores({id3: "++id, artist, title, duration, img, audio"});
db.open().catch(function(e) {xalert("Open failed: " + e);});


function handleFileSelection(e) {
  //reset globals
  imgStore = undefined;
  fileStore = e.target.files[0];
  
  var url = URL.createObjectURL(fileStore);
  ID3.loadTags(url, function() {
    var tags = ID3.getAllTags(url);
    if (tags.picture !== undefined) {
			// Convert picture to base64
      var image = tags.picture; var base64String = "";
      for (var i = 0; i < image.data.length; i++) {base64String += String.fromCharCode(image.data[i]);}
      imgurl = "data:" + image.format + ";base64," + window.btoa(base64String);
      imgStore = imgurl;
      elmImage.src = imgStore;
		}else{
      elmImage.src = "";
    }
    if (tags.title !== undefined) {
      elmTitle.value = tags.title;
    }else{
      elmTitle.value = "";
    }
    if (tags.artist !== undefined) {
      elmArtist.value = tags.artist;
    }else{
      elmArtist.value = "";
    }
  }, {
    dataReader: ID3.FileAPIReader(fileStore),
    tags: ["artist", "title", "picture"]
  });
  elmAudio.src = url;
  handleView();
}

function handleAdd(){
  var image = imgStore;
  var artist = elmArtist.value;
  var title = elmTitle.value;
  var duration = secondsToHms(elmAudio.duration);
  db.id3.add({artist: artist, title: title, duration: duration, img: image, audio: fileStore});
  handleView();
}

function handleView() {
  elmTable.innerHTML = "";
  db.id3.each(function(result) {
    var tr = "<tr>";
    if (result.img !== undefined){
      var td1 = "<td><img width='50px' src=\"" + result.img + "\"></td>";
    }else{
      var td1 = "<td></td>";
    }
    var td2 = "<td><a onclick=\"handlePlay(" + result.id + ")\">Play</a></td>";
    var td3 = "<td>" + result.title + "</td>";
    var td4 = "<td>" + result.artist + "</td>";
    var td5 = "<td><a onclick=\"handleRemove(" + result.id + ")\">Remove</a></td>";
    var td6 = "<td>" + result.duration + "</td>";
    var tr2 = "</tr></td>";
    elmTable.innerHTML = elmTable.innerHTML + tr+td1+td2+td3+td4+td5+td6+tr2;
  })
}

function handlePlay(i){
  db.id3.where("id").equals(i).each(function(result) {
    elmAudio.src = URL.createObjectURL(result.audio);
    elmImage.src = result.img;
  })
  handleView();
}
const musicdb = (dbname, table) => {
	// create database
	const db = new Dexie(dbname);
	db.version(1).stores(table);
	db.open();
	return db;
}

let db = musicdb('musicdb', {
	albums: '++id, album, singer, year'
});

// insert function
const bulkcreate = (dbtable, data) => {
	let flag = empty(data);
	if(flag) {
		dbtable.bulkAdd([data]);
		console.log('datos insertados correctamente')	
	} else {
		console.log('por favor introduzca los datos')	
	}
	return flag;
}

// check textbox validation
const empty = object => {
	let flag = false;
	for(const value in object) {
		if(object[value] != '' && object.hasOwnProperty(value)) {
			flag = true;
		} else {
			flag = false;
		}
	}
	return flag;
}

// input tags
const albumid    = document.getElementById('albumid');
const albumname  = document.getElementById('albumname');
const singername = document.getElementById('singername');
const albumyear  = document.getElementById('albumyear');

// buttons
const btncreate = document.getElementById('btn-create');
const btnread   = document.getElementById('btn-read');
const btnupdate = document.getElementById('btn-update');
const btndelete = document.getElementById('btn-delete');

// not found
const notfound = document.getElementById('notfound');

// insert value using create button
btncreate.onclick = (event) => {
	let flag = bulkcreate(db.albums, {
		album:  albumname.value,
		singer: singername.value,
		year:   albumyear.value
	})
	console.log(flag);
	/*
	albumname.value  = '';
	singername.value = '';
	albumyear.value  = '';
	*/
	albumname.value = singername.value = albumyear.value = '';
	// set id textbox value
	getData(db.albums, (data) => {
		// console.log(data.id);
		albumid.value = data.id + 1 || 1;
	});
	table();
	// display message
	let insertmsg = document.querySelector('.insertmsg');
	getMsg(flag, insertmsg);
}

// create event on read btn
btnread.onclick = table;

// update event
btnupdate.onclick = () => {
	const id = parseInt(albumid.value || 0);
	if(id) {
		db.albums.update(id, {
			album:  albumname.value,
			singer: singername.value,
			year:   albumyear.value
		})
		.then((updated) => {
			let get = updated ? true : false;
			// display message
			let updatemsg = document.querySelector('.updatemsg');
			getMsg(get, updatemsg);
			albumname.value = singername.value = albumyear.value = '';
			// let get = updated ? 'data updated' : "couldn't update data";
			// console.log(get);
		})
	} else {
		console.log(`Por favor selecciona ID: ${id}`);
	}
}

// delete records
btndelete.onclick = () => {
	db.delete();
	db = musicdb('musicdb', {
		albums: '++id, album, singer, year'
	});
	db.open();
	table();
	textID(albumid);
	// display message
	let deletemsg = document.querySelector('.deletemsg');
	getMsg(true, deletemsg);
}

// window onload event
window.onload = () => {
	textID(albumid);
}

function textID(textboxid) {
	getData(db.albums, data => {
		textboxid.value = data.id + 1 || 1;
	})
}

function table() {
	const tbody = document.getElementById('tbody');
	while(tbody.hasChildNodes()) {
		tbody.removeChild(tbody.firstChild);
	}
	getData(db.albums, (data) => {
		// console.log(data);
		if(data) {
			createEle('tr', tbody, tr => {
				for(const value in data) {
					createEle('td', tr, td => {
						// td.textContent = data.price === data[value] ? `${data[value]}€` : data[value];
						td.textContent = data[value];
					})
				}
				createEle('td', tr, td => {
					createEle('i', td, i => {
						i.className += 'fas fa-edit btnedit';
						i.setAttribute('data-id', data.id);
						i.onclick = editbtn;
					})
				})
				createEle('td', tr, td => {
					createEle('i', td, i => {
						i.className += 'fas fa-trash-alt btndelete';
						i.setAttribute('data-id', data.id);
						i.onclick = deletebtn;
					})
				})
			})
		} else {
			notfound.textContent = "no se encontraron datos";
		}
	})
	// createEle('td', tbody, (td) => {
	// 	console.log(td);
	// 	console.log(tbody);
	// })
	// let td = document.createElement('td');
	// console.log(tbody);
	// tbody.appendChild(td);
	// console.log(td);
}

function editbtn(event) {
	// console.log(event.target);
	// console.log(event.target.dataset.id);
	let id = parseInt(event.target.dataset.id);
	// console.log(typeof id);
	db.albums.get(id, data => {
		// console.log(data);
		albumid.value    = data.id     || 0;
		albumname.value  = data.album  || "";
		singername.value = data.singer || "";
		albumyear.value  = data.year   || 0;
	})
}

function deletebtn(event) {
	let id = parseInt(event.target.dataset.id)
	db.albums.delete(id);
	table();
}

function getMsg(flag, element) {
	if(flag) {
		element.className += ' movedown';
		setTimeout(() => {
			element.classList.forEach(classname => {
				classname == 'movedown' ? undefined : element.classList.remove('movedown');
			})
		},4000)
	}
}

// get data from the database
const getData = (dbtable, fn) => {
	let index = 0;
	let obj = {};
	dbtable.count((count) => {
		// console.log(count);
		if(count) {
			dbtable.each(table => {
				// console.log(table);
				obj = Sortobj(table)
				// console.log(obj);
				fn(obj, index++);
			})
		} else {
			fn(0);
		}
	});
}
var taskInput = document.getElementById("new-task"); //new-task
var addButton = document.getElementsByTagName("button")[0]; //first button
var incompleteTasksHolder = document.getElementById("incomplete-tasks"); //incomplete-tasks
var completedTasksHolder = document.getElementById("completed-tasks"); //completed-tasks

//New Task List Item
var createNewTaskElement = function(taskString) {
  //Create List Item
  var listItem = document.createElement("li");

  //input (checkbox)
  var checkBox = document.createElement("input"); // checkbox

  //label
  var label = document.createElement("label");

  //input (text)
  var editInput = document.createElement("input"); // text

  //button.edit
  var editButton = document.createElement("button");

  //button.delete
  var deleteButton = document.createElement("button");

  //Each element needs modifying
  checkBox.type = "checkbox";
  editInput.type = "text";

  editButton.innerText = "Edit";
  editButton.className = "edit";
  deleteButton.innerText = "Delete";
  deleteButton.className = "delete";

  label.innerText = taskString;

  //Each element needs appending
  listItem.appendChild(checkBox);
  listItem.appendChild(label);
  listItem.appendChild(editInput);
  listItem.appendChild(editButton);
  listItem.appendChild(deleteButton);

  return listItem;
}

//Add a new task
var addTask = function() {
  console.log("Add task...");
  
  //Create a new list item with the text from #new-task:
  var listItem = createNewTaskElement(taskInput.value);

  //Append listItem to incompleteTasksHolder
  incompleteTasksHolder.appendChild(listItem);
  bindTaskEvents(listItem, taskCompleted);

  taskInput.value = "";
}

//Edit an existing task
var editTask = function() {
  console.log("Edit task...");
  var listItem = this.parentNode;
  var editInput = listItem.querySelector("input[type=text]");
  var label = listItem.querySelector("label");
  var containsClass = listItem.classList.contains("editMode");
  var editButton = listItem.getElementsByTagName("button")[0];

  //If the class of the parent is .editMode
  if (containsClass) {
    //Switch from .editMode
    //label text become the input's value
    label.innerText = editInput.value;
    editButton.innerText = "Edit";
    //else
  } else {
    //Switch to .editMode
    //input value becomes the label's text
    editInput.value = label.innerText;
    editButton.innerText = "Save";
  }
  //Toggle .editMode on the parent
  listItem.classList.toggle("editMode");
}

//Delete an existing task
var deleteTask = function() {
  console.log("Delete task...");
  var listItem = this.parentNode;
  var ul = listItem.parentNode;

  //Remove the parent list item from the ul
  ul.removeChild(listItem);
}

//Mark a task as complete
var taskCompleted = function() {
  console.log("Task complete...");

  //When the Checkbox is checked
  //Append the task list item to the #completed-tasks
  var listItem = this.parentNode;
  completedTasksHolder.appendChild(listItem);
  bindTaskEvents(listItem, taskIncomplete);
}

//Mark a task as incomplete
var taskIncomplete = function() {
  console.log("Task incomplete...");

  //When the checkbox is unchecked
  //Append the task list item to the #incomplete-tasks
  var listItem = this.parentNode;
  incompleteTasksHolder.appendChild(listItem);
  bindTaskEvents(listItem, taskCompleted);
}

var bindTaskEvents = function(taskListItem, checkboxEventHandler) {
  console.log("Bind list item events");

  //Select taskListItem's children
  var checkBox = taskListItem.querySelector("input[type=checkbox]");
  var editButton = taskListItem.querySelector("button.edit");
  var deleteButton = taskListItem.querySelector("button.delete");

  //Bind editTask to edit button
  editButton.onclick = editTask;

  //Bind deleteTask to delete button
  deleteButton.onclick = deleteTask;

  //Bind checkBoxEventHandler to checkbox
  checkBox.onchange = checkboxEventHandler;
}

var ajaxRequest = function() {
  console.log("AJAX request");
}

//Set the click handler to the addTask function
//addButton.onclick = addTask;
addButton.addEventListener("click", addTask);
addButton.addEventListener("click", ajaxRequest);

//addButton.onclick = ajaxRequest;

//Cycle over incompleteTasksHolder ul list items
for (var i = 0; i < incompleteTasksHolder.children.length; i++) {
  //Bind events to item's children (taskCompleted)
  bindTaskEvents(incompleteTasksHolder.children[i], taskCompleted);
}
//Cycle over completedTasksHolder ul list items
for (var i = 0; i < completedTasksHolder.children.length; i++) {
  //Bind events to item's children (taskIncomplete)
  bindTaskEvents(completedTasksHolder.children[i], taskIncomplete);
}
<script>

eval(‘alert(“Your query string was ‘ + unescape(document.location.search) + ‘”);’);

</script>
// sort object
const Sortobj = sortobj => {
	let obj = {};
	obj = {
		id:     sortobj.id,
		album:  sortobj.album,
		singer: sortobj.singer,
		year:   sortobj.year
	}
	return obj;
}

// create dynamic element
const createEle = (tagname, appendTo, fn) => {
	const element = document.createElement(tagname);
	if(appendTo) appendTo.appendChild(element);
	if(fn) fn(element);
}
function handleRemove(i){
  db.id3.where("id").equals(i).delete();
  handleView();
}

function secondsToHms(d) {
	d = Number(d);
	var h = Math.floor(d / 3600);
	var m = Math.floor(d % 3600 / 60);
	var s = Math.floor(d % 3600 % 60);
	return ((h > 0 ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s);
}

handleView();