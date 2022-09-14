function initPivot(pivotState) {
    var pivot = document.getElementById(pivotState.id);

    var tds = pivot.getElementsByClassName('pivot-row-header');
    for (var j=0; j<pivotState.rowCollapseLevels.length; j+=1) {
        var rowLevel = pivotState.rowCollapseLevels[j];
        for (var i=0; i<tds.length; i+=1) {
        var td = tds[i];
        if (td.dataset.rowField != rowLevel)
            continue;
        var icon = td.firstElementChild;
        if (icon && icon.className.indexOf('minus') > -1)
            expandCollapseRow(icon, pivotState);
        }
    }

    tds = pivot.getElementsByClassName('pivot-column-header');
    for (var j=0; j<pivotState.colCollapseLevels.length; j+=1) {
        var colLevel = pivotState.colCollapseLevels[j];
        for (var i=0; i<tds.length; i+=1) {
        var td = tds[i];
        if (td.dataset.columnField != colLevel)
            continue;
        var icon = td.firstElementChild;
        if (icon && icon.className.indexOf('minus') > -1)
            expandCollapseColumn(icon, pivotState);
        }
    }

    pivot.style.visibility = 'visible';
}

function changeLayer(el, expand) {
    el.dataset.layer -= expand ? -1 : 1;
    if (expand && 1*el.dataset.layer > 0)
        el.style.display = '';
    else if (! expand && 1*el.dataset.layer < 1)
        el.style.display = 'none';
}

function expandCollapseRow(icon, pivotState) {
    var iconName = icon.className;
    var expand = iconName.indexOf('plus') > -1;
    var td = icon.parentElement;
    var el = td.nextElementSibling;
    while (el) {
        changeLayer(el, expand);
        el = el.nextElementSibling;
    }
    el = td.parentElement;
    var i = 1;
    while (i < 1*td.rowSpan) {
        el = el.nextElementSibling;
        for (var j = 0; j<el.children.length; j+=1) {
            var child = el.children[j];
            if (child.classList.contains('pivot-data-cell') && 
                i === td.rowSpan - 1)  {
                child.classList.toggle('pivot-data-cell-row-total');
                continue;
            }
            changeLayer(child, expand);
        }
        i += 1;
    }
    td.colSpan = expand ? 1 : pivotState.numRowFields - td.dataset.rowField;
    icon.className = expand ? iconName.replace('plus', 'minus') : 
        iconName.replace('minus', 'plus');
}

function expandCollapseColumn(icon, pivotState) {
    var iconName = icon.className;
    var expand = iconName.indexOf('plus') > -1;
    var td = icon.parentElement;
    var rangeLeft = 1*td.dataset.columnIndex;
    var rangeRight = rangeLeft + 1*td.colSpan/pivotState.numDataFields;
    var el = td.parentElement;
    el = el.nextElementSibling;
    while (el) {
        var children = el.children;
        for (var i=0; i<children.length; i+=1) {
        var child = children[i];
        var columnIndex = 1*child.dataset.columnIndex;
        if (child.classList.contains('pivot-data-cell') 
            && columnIndex === rangeRight - 1) {
            child.classList.toggle('pivot-data-cell-column-total');
            child.colSpan = expand ? 1 : td.colSpan/pivotState.numDataFields;
        }
        else if (rangeLeft <= columnIndex && columnIndex < rangeRight) 
            changeLayer(child, expand);
        }
        el = el.nextElementSibling;
    }
    td.rowSpan = expand ? 1 : pivotState.numColFields - td.dataset.columnField;
    icon.className = expand ? iconName.replace('plus', 'minus') : 
        iconName.replace('minus', 'plus');
}

function showHideColumn(td, pivotState, show) {
    var rangeLeft = 1*td.dataset.columnIndex;
    var rangeRight = rangeLeft + 1*td.colSpan/pivotState.numDataFields;
    var el = td.parentElement;
    el = el.nextElementSibling;
    while (el) {
        var children = el.children;
        for (var i=0; i<children.length; i+=1) {
        var child = children[i];
        var columnIndex = 1*child.dataset.columnIndex;
        if (rangeLeft <= columnIndex && columnIndex < rangeRight) 
            changeLayer(child, show);
        }
        el = el.nextElementSibling;
    }
    changeLayer(td, show);
}

