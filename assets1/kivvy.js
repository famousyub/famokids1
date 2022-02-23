//prefixes of implementation that we want to test
window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;

//prefixes of window.IDB objects
window.IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || window.msIDBTransaction;
window.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange || window.msIDBKeyRange

if (!window.indexedDB) {
    window.alert("Your browser doesn't support a stable version of IndexedDB.")
}

const employeeData = [{
    id: "00-01",
    name: "gopal",
    age: 35,
    email: "gopal@tutorialspoint.com"
}, {
    id: "00-02",
    name: "prasad",
    age: 32,
    email: "prasad@tutorialspoint.com"
}];

var db;
var request = window.indexedDB.open("newDatabase", 1);

request.onerror = function (event) {
    console.log("error: ");
};

request.onsuccess = function (event) {
    db = request.result;
    console.log("success: " + db);
    loadTable();
};

request.onupgradeneeded = function (event) {
    var db = event.target.result;
    var objectStore = db.createObjectStore("employee", {
        keyPath: "id"
    });

    for (var i in employeeData) {
        objectStore.add(employeeData[i]);
    }
}

function loadTable() {
    var employees = "";
    $('.employee').remove();

    var objectStore = db.transaction("employee").objectStore("employee");
    objectStore.openCursor().onsuccess = function (event) {
        var cursor = event.target.result;
        if (cursor) {
            employees = employees.concat(
                '<tr class="employee">' +
                '<td class="ID">' + cursor.key + '</td>' +
                '<td class="Name">' + cursor.value.name + '</td>' +
                '<td class="Age">' + cursor.value.age + '</td>' +
                '<td class="Email">' + cursor.value.email + '</td>' +
                '</tr>');

            cursor.continue(); // wait for next event
        } else {
            $('.header').after(employees); // no more events
        }
    };
}

function addEmployee() {
    var employeeID = $('#add_id').val();
    var name = $('#add_name').val();
    var age = $('#add_age').val();
    var email = $('#add_email').val();
    var request = db.transaction(["employee"], "readwrite")
        .objectStore("employee")
        .add({
            id: employeeID,
            name: name,
            age: age,
            email: email
        });

    request.onsuccess = function (event) {
        loadTable();
        clearButtons();
    };

    request.onerror = function (event) {
        alert("error");
    }
}

function deleteEmployee() {
    var employeeID = $('#delete_id').val();
    var request = db.transaction(["employee"], "readwrite")
        .objectStore("employee")
        .delete(employeeID);

    request.onsuccess = function (event) {
        loadTable();
        clearButtons();
    };
}

function clearButtons() {
    $('#add_id').val("");
    $('#add_name').val("");
    $('#add_age').val("");
    $('#add_email').val("");
    $('delete_id').val("");
}














let DB;

// Selectors 
const form = document.querySelector('form'),
    petName = document.querySelector('#pet'),
    ownerName = document.querySelector('#owner'),
    phone = document.querySelector('#phone'),
    date = document.querySelector('#date'),
    hour = document.querySelector('#hour'),
    symptoms = document.querySelector('#symptoms'),
    headerAdministra = document.querySelector('#administra'),
    appointments = document.querySelector('#appointments');

// wait for the DOM
document.addEventListener('DOMContentLoaded', () => {

    //Creating the database.
    let createDB = window.indexedDB.open('appointments', 1);

    // If there is an error show it.
    createDB.onerror = function () {
        console.log('There was an error');
    }
    // If all goes fine then shows the account, and assign the data base.

    createDB.onsuccess = function () {
        //Asign to the data base.
        DB = createDB.result;
        showAppointments();
    }
    // This method just runs once and is ideal for create the Schema.
    createDB.onupgradeneeded = function (e) {
        // This event is the same database
        let db = e.target.result;

        //Define the object store, take 2 params, 1 the name, 2 the options.
        //keyPath is the index of te data base.
        let objectStore = db.createObjectStore('appointments', {
            keyPath: 'key',
            autoIncrement: true
        });

        // Create index and fields of the databse, createIndex:  3 parameters, name, keyPath and options.
        objectStore.createIndex('petName', 'petName', { unique: false });
        objectStore.createIndex('ownerName', 'ownerName', { unique: false });
        objectStore.createIndex('phone', 'phone', { unique: false });
        objectStore.createIndex('date', 'date', { unique: false });
        objectStore.createIndex('hour', 'hour', { unique: false });
        objectStore.createIndex('symptoms', 'symptoms', { unique: false });
    }
});

form.addEventListener('submit', (e) => {
    e.preventDefault();
    const appointment = {}
    appointment.petName = petName.value;
    appointment.ownerName = ownerName.value;
    appointment.phone = phone.value;
    appointment.date = date.value;
    appointment.hour = hour.value;
    appointment.symptoms = symptoms.value;


    //In the IndexedDB the transactions are used.
    let transaction = DB.transaction(['appointments'], 'readwrite');
    let objectStore = transaction.objectStore('appointments');

    let request = objectStore.add(appointment);

    console.log(request);


    request.onsuccess = () => {
        form.reset();
    }

    transaction.oncomplete = () => {
        console.log('Appointment added.');
        showAppointments();
    }

    transaction.onerror = () => {
        console.log('There was an error.');
    }

});


function showAppointments() {

    //Clear the previous ones.
    while (appointments.firstChild) {

        appointments.removeChild(appointments.firstChild);
    }
    //Creating objectStore
    let objectStore = DB.transaction('appointments').objectStore('appointments');

    //Returning the request.
    objectStore.openCursor().onsuccess = function (e) {

        let cursor = e.target.result;
        let count = 0

        if (cursor) {

            let appointmentHTML = document.createElement('li');
            appointmentHTML.setAttribute('data-appointment-id', cursor.value.key);
            appointmentHTML.classList.add('list-group-item');

            appointmentHTML.innerHTML = `
            <p class="font-weight-bold">Mascota: <span class ="font-weight-normal">${cursor.value.petName}</span></p>
            <p class="font-weight-bold">Owner: <span class ="font-weight-normal">${cursor.value.ownerName}</span></p>
            <p class="font-weight-bold">Phone: <span class ="font-weight-normal">${cursor.value.phone}</span></p>
            <p class="font-weight-bold">Date: <span class ="font-weight-normal">${cursor.value.date}</span></p>
            <p class="font-weight-bold">Hour: <span class ="font-weight-normal">${cursor.value.hour}</span></p>
            <p class="font-weight-bold">Symptoms: <span class ="font-weight-normal">${cursor.value.symptoms}</span></p>
            `;

            //Adding a delete Button.
            let deleteButton = document.createElement('button');
            deleteButton.classList.add('delete', 'btn', 'btn-danger');
            deleteButton.innerHTML = `<span aria-hidden="true">x Cancel</span>`;
            deleteButton.onclick = deleteAppointment;
            appointmentHTML.appendChild(deleteButton);

            //Append in the father.
            appointments.appendChild(appointmentHTML);
            headerAdministra.textContent = `Pending appointments: ${appointments.childElementCount}`

            cursor.continue();


        } else {

            if (!appointments.firstChild) {
                headerAdministra.textContent = 'Add appointments';
                let list = document.createElement('p');
                list.classList.add('text-center');
                list.textContent = 'There aren\'t any appointments.';
                appointments.appendChild(list);
            }

        }
    }

}

function deleteAppointment(e) {
    let appointmentId = Number(e.target.parentElement.getAttribute('data-appointment-id'));

    let transaction = DB.transaction(['appointments'], 'readwrite');
    let objectStore = transaction.objectStore('appointments');
    let request = objectStore.delete(appointmentId);

    transaction.oncomplete = (e) => {
        showAppointments();
    }
}



const autoCompleteJS = new autoComplete({
  data: {
    src: async function () {
      // Loading placeholder text
      document
        .querySelector("#autoComplete")
        .setAttribute("placeholder", "Loading...");
      // Fetch External Data Source
      const source = await fetch(
        "https://tarekraafat.github.io/autoComplete.js/demo/db/generic.json"
      );
      const data = await source.json();
      // Post loading placeholder text
      document
        .querySelector("#autoComplete")
        .setAttribute("placeholder", "Food & Drinks");
      // Returns Fetched data
      return data;
    },
    key: ["food", "cities", "animals"],
    cache: true,
    results: (list) => {
      // Filter duplicates
      const filteredResults = Array.from(
        new Set(list.map((value) => value.match))
      ).map((food) => {
        return list.find((value) => value.match === food);
      });

      return filteredResults;
    }
  },
  trigger: {
    event: ["input", "focus"],
    condition: () => {
      return true;
    }
  },
  placeHolder: "Search for Food & Drinks!",
  resultsList: {
    noResults: (list, query) => {
      // No Results List Message
      const message = document.createElement("li");
      message.setAttribute("class", "no_result");
      message.setAttribute("tabindex", "1");
      message.innerHTML = `<span style="display: flex; align-items: center; font-weight: 100; color: rgba(0,0,0,.2);">Found No Results for "${query}"</span>`;
      list.appendChild(message);
    }
  },
  resultItem: {
    highlight: {
      render: true
    },
    content: (data, element) => {
      // Modify Results Item Style
      element.style = "display: flex; justify-content: space-between;";
      // Modify Results Item Content
      element.innerHTML = `<span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
        ${data.match}</span>
        <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.2);">
      ${data.key}</span>`;
    }
  },
  onSelection: (feedback) => {
    document.querySelector("#autoComplete").blur();
    // Prepare User's Selected Value
    const selection = feedback.selection.value[feedback.selection.key];
    // Render selected choice to selection div
    document.querySelector(".selection").innerHTML = selection;
    // Replace Input value with the selected value
    document.querySelector("#autoComplete").value = selection;
    // Console log autoComplete data feedback
    console.log(feedback);
  }
});

// Toggle Search Engine Type/Mode
document.querySelector(".toggler").addEventListener("click", function () {
  // Holds the toggle button alignment
  const toggle = document.querySelector(".toggle").style.justifyContent;

  if (toggle === "flex-start" || toggle === "") {
    // Set Search Engine mode to Loose
    document.querySelector(".toggle").style.justifyContent = "flex-end";
    document.querySelector(".toggler").innerHTML = "Loose";
    autoCompleteJS.searchEngine = "loose";
  } else {
    // Set Search Engine mode to Strict
    document.querySelector(".toggle").style.justifyContent = "flex-start";
    document.querySelector(".toggler").innerHTML = "Strict";
    autoCompleteJS.searchEngine = "strict";
  }
});

// Toggle results list and other elements
const action = function (action) {
  const github = document.querySelector(".github-corner");
  const title = document.querySelector("h1");
  const mode = document.querySelector(".mode");
  const selection = document.querySelector(".selection");
  const footer = document.querySelector(".footer");

  if (action === "dim") {
    title.style.opacity = 1;
    mode.style.opacity = 1;
    selection.style.opacity = 1;
  } else {
    title.style.opacity = 0.3;
    mode.style.opacity = 0.2;
    selection.style.opacity = 0.1;
  }
};

// Toggle event for search input
// showing & hiding results list onfocus/blur
["focus", "blur"].forEach(function (eventType) {
  document
    .querySelector("#autoComplete")
    .addEventListener(eventType, function () {
      // Hide results list & show other elements
      if (eventType === "blur") {
        action("dim");
      } else if (eventType === "focus") {
        // Show results list & hide other elements
        action("light");
      }
    });
});












    let db;
    let request = window.indexedDB.open('newDataBase', 1);
    request.addEventListener('error', e => {
            console.log('?????? ', e)
    });
    request.addEventListener('success', e => {  
      db = request.result;          
      loadTasks();
      document.querySelector('.input').addEventListener('keyup', addTask);     
      //document.querySelector('.plan li').addEventListener('click', done);      
    });
    request.addEventListener('upgradeneeded', e => {
      let db = e.target.result;
      let objectStore = db.createObjectStore("tasks", { keyPath: "uid" });      
    });

    
    function loadTasks(){
      let plan = document.querySelector('.plan');
      plan.innerHTML = '';
      let done = document.querySelector('.done');
      done.innerHTML = '';

      let plans = document.createDocumentFragment();
      let dones = document.createDocumentFragment();
      let objectStore = db.transaction("tasks").objectStore("tasks");
      objectStore.openCursor().onsuccess = function(e){
          let cursor = e.target.result;
          if (cursor){
            let task = document.createElement('li');              
            task.innerHTML = cursor.value.title;                  
            let a = document.createElement('a'); 
            a.innerHTML = '???????';
            a.href = '#';
            a.setAttribute('data-uid', cursor.key);
            a.addEventListener('click', function(e) {
                        e.preventDefault();
                        deleteTask(this.getAttribute('data-uid'));
                    });
            task.appendChild(a);
            if (cursor.value.state === 'done'){
              task.className = 'done';              
              dones.appendChild(task);
            }              
            else{
              task.addEventListener('click', function(e) {
                        e.preventDefault();
                        doneTask(this.lastElementChild.getAttribute('data-uid'));
                    });
              plans.appendChild(task);
            }              
            cursor.continue();
          } 
          else{
            plan.appendChild(plans);
            done.appendChild(dones);
          }            
      }
    }

    function addTask(e){
      let title = document.querySelector('.input').value;
      if ((e.key === 'Enter' || e.keyCode === 13) && title) {        
        let uid = uuidv4();
        let state = 'plan';
        let request = db.transaction(['tasks'], 'readwrite').objectStore('tasks').add({
                uid,
                title,
                state
            });
            request.addEventListener('error', e => {
                alert('?????? ?????????? ???????!')
            });

            request.addEventListener('success', e => {
                loadTasks();
                document.querySelector('.input').value = '';                
            });
      }
    }//addTask
    
    function doneTask(uid){
      const objectStore = db.transaction(['tasks'], "readwrite").objectStore('tasks');
      let getRequest = objectStore.get(uid);
      getRequest.onsuccess = () => {
        let task = getRequest.result;
        task.state = 'done';
        let updateRequest = objectStore.put(task);
        updateRequest.addEventListener('success', e => {
                  loadTasks();        
              });
      }
    }
    function deleteTask(uid){
      let request = db.transaction(['tasks'], 'readwrite')
            .objectStore('tasks').delete(uid)

            request.addEventListener('success', e => {
                loadTasks();        
            })
    }
    
    
    
    const btnJqueryHtml = document.getElementById('btn-jquery-html')
const btnJqueryText = document.getElementById('btn-jquery-text')
const input = document.getElementById('user-input')

const copy = (target) => {
  const node = target.nextSibling.nextSibling
  const range = document.createRange()
  range.selectNode(node)
  window.getSelection().addRange(range)
  document.execCommand('copy')
  window.getSelection().removeRange(range)
}

btnJqueryHtml.onclick = () => {
  const userInput = input.value
  $('#reflected').html(userInput)
}

btnJqueryText.onclick = () => {
  const userInput = input.value
  $('#reflected').text(userInput)
}
var Emitter = function(){
   this.Store = {};
};

Emitter.prototype.emit = function(key, data){
   if(this.Store[key]){
      for(var fn in this.Store[key])
         this.Store[key][fn](data || undefined);
   }
};

Emitter.prototype.on = function(key, fn){
   if(this.Store[key]) this.Store[key].push(fn);
   else this.Store[key] = [fn];
}

var _x0202893 = new Emitter();

_x0202893.on('ping', function(){
   alert('pong');
});

_x0202893.on('hello', function( data ){
   alert("Received Event with data : " + data);
});

_x0202893.on('marco', function(){
   alert("Polo 1");
});

_x0202893.on('marco', function(){
   alert('Polo 2');
});
    
console.clear();

let btns = document.querySelectorAll('button');

for (i of btns) {
  i.addEventListener('click', function() {
    document.querySelector('.msg').innerHTML = this.innerHTML;
  });
}
    
    
    
    
    new Vue({
  el: '#app',
  data: {
    greeting: 'Hello Vue!'
  }
})
    
    
    $('form').on('submit', function(e) {
  e.preventDefault();
  
  var ov = $('#test').val();
  
  $('#output-inner').get(0).innerHTML = ov;
  $('#output-html').html(ov);	// Comment this out to see how innerHTML does not fire the dialog
  $('#output-text').text(ov);
  
});