function onAddRankingButtonClick(button) {
    var table = document.getElementById('fees-structure-form');
    var i = table.children[0].children.length - 1;
    var row = table.insertRow();
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);        
    var cell3 = row.insertCell(3);        
                            
    cell0.innerHTML = '<input id="course-' + i + '" value=""/>';
    cell1.innerHTML = '<input id="fees-' + i + '" value=""/>';
    cell2.innerHTML = '<input id="duration-' + i + '" value=""/>';
    cell3.innerHTML = '<button data-index="' + i + '" class="btn btn-danger" onclick="onDeleteRankingButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button>';   
}

function onDeleteRankingButtonClick(button) {
    var index = Number(button.getAttribute('data-index'));
    var rankings = getRankings();

    //remove from array.
    rankings.splice(index, 1);    

    //update rankings
    setRankings(rankings);

    //update table DOM
    updateTableDOM(rankings, 'fees-structure-form', true);
}

function onSaveChangesClick(button) {
    var rankings = [];
    var table = document.getElementById('fees-structure-form');
    var rows = table.children[0].children.length;

    for(var i = 1; i < rows; i++) {
        rankings.push({
            'course': document.getElementById('course-' + (i - 1)).value,
            'fees': document.getElementById('fees-' + (i - 1)).value,
            'duration': document.getElementById('duration-' + (i - 1)).value,
        })
    }
    setRankings(rankings);
    updateTableDOM(rankings,'fees-structure');
    document.getElementById("modal-close").click();
}

function getRankings() {
    var str = document.getElementById('fees_structure').value;
    return JSON.parse(str);    
}

function setRankings(arr) {
    var rankings = document.getElementById('fees_structure');
    rankings.value = JSON.stringify(arr);
}

function updateTableDOM(arr, id, editable) {
    var table = document.getElementById(id);

    //remove all rows
    var i = table.children[0].children.length - 1;
    while(table.children[0].children.length != 1) {
        table.deleteRow(i--);
    }

    //add rows as per arr
    for(var i = 0; i < arr.length; i++) {
        var row = table.insertRow();                

        if (editable) {
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
            var cell2 = row.insertCell(2);
            var cell3 = row.insertCell(3);
            cell0.innerHTML = '<input id="course-' + i + '" value="' + arr[i].course + '"/>';
            cell1.innerHTML = '<input id="fees-' + i + '" value="' + arr[i].fees + '"/>';
            cell2.innerHTML = '<input id="duration-' + i + '" value="' + arr[i].duration + '"/>';
            cell3.innerHTML = '<button data-index="' + i + '" class="btn btn-danger" onclick="onDeleteRankingButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button>';
        } else {
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);        
            var cell2 = row.insertCell(2);        
            cell0.innerHTML = arr[i].course;
            cell1.innerHTML = arr[i].fees;            
            cell2.innerHTML = arr[i].duration;            
        }                  
        
    }
}