function generateStub() {
    var current = document.getElementById('name').value;
    current = current.replace(/[^a-z0-9]/gi, '').toLowerCase();
    document.getElementById('stub').value = current;
}
function generatePassword() {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 8;
    var password = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        password += chars.substring(rnum,rnum+1);
    }
    document.getElementById('password').value = password;
}
function addAttachment() {
    // Add attachment
}

function resizeNav() {

    var nav = document.getElementById('nav');
    var resizer = document.getElementsByClassName('resizer');
    if(nav.classList.contains('large')) {
        nav.className = 'large';
    } else {
        nav.className = 'small';
    }

    if(nav.className == 'large') {
        nav.style.width = '80px';
        document.getElementById('main').style.marginLeft = '80px';
        var children = document.getElementsByClassName('resizable');
        for(var i = 0; i < children.length; i++) {
            children[i].style.display = 'none';
        }
        nav.className  = 'small';
    } else {
        nav.style.width = '300px';
        document.getElementById('main').style.marginLeft = '300px';
        var children = document.getElementsByClassName('resizable');
        for(var i = 0; i < children.length; i++) {
            children[i].style.display = 'inline';
        }
        nav.className  = 'large';

    }

}

function closeNotification(box) {
    box.style.display = "none";
}

function selectAll(ele) {
    var checkboxes = document.getElementsByClassName('issue-checkbox');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = true;
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }
    checkSelected();
}

function checkSelected() {
    var checkboxes = document.getElementsByClassName('issue-checkbox');
    var checkCount = 0;
    var selectedString = "";

    // Iterate through all of the selected issues
    for (var i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].checked) {
            checkCount++;
            selectedString += checkboxes[i].value + ',';
        }
    }
    // Chop off trailing comma
    selectedString = selectedString.substring(0, selectedString.length - 1);

    // Show block if we have things selected
    if(checkCount > 0) {
        document.getElementById('table-actions').style.display = 'block';
        document.getElementById('main').style.paddingBottom = '100px';
    } else {
        document.getElementById('table-actions').style.display = 'none';
        document.getElementById('main').style.paddingBottom = '20px';
    }

    // Finally print the amount selected
    var print = document.getElementById('selectedAmount');
    var indexURL = document.URL.split('?')[0];

    /*
    if(document.getElementbyId('assign')) {
        document.getElementById('assign').childNodes();
    }*/
    if(document.getElementById('assign_sponge')) {
        document.getElementById('assign_sponge').href = indexURL + "/assign/" + selectedString + "?group=sponge";
    }
    if(document.getElementById('assign_client')) {
        document.getElementById('assign_client').href = indexURL + "/assign/" + selectedString + "?group=client";
    }
    if(document.getElementById('claim')) {
        document.getElementById('claim').href = indexURL + "/claim/" + selectedString;
    }
    if(document.getElementById('resolve')) {
        document.getElementById('resolve').href = indexURL + "/resolve/" + selectedString;
    }
    if(document.getElementById('delete')) {
        document.getElementById('delete').href = indexURL + "/delete/" + selectedString;
    }
    print.innerHTML = checkCount.toString();
}
