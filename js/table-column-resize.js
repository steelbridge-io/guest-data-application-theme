/**
 * Table Column Resizing
 * Adds Excel-like column resize functionality to #gda-table
 */

document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('gda-table');
    if (!table) return;

    const headerRow = table.querySelector('thead tr');
    if (!headerRow) return;

    const headers = headerRow.querySelectorAll('th');
    
    headers.forEach((th, index) => {
        // Skip adding resize handle to the last column
        if (index === headers.length - 1) return;
        
        // Create resize handle
        const resizer = document.createElement('div');
        resizer.classList.add('column-resizer');
        resizer.style.cssText = 'position: absolute; top: 0; right: 0; width: 5px; height: 100%; cursor: col-resize; user-select: none; z-index: 10;';
        
        // Make th position relative so resizer can be positioned
        th.style.position = 'relative';
        th.appendChild(resizer);
        
        let startX, startWidth;
        
        resizer.addEventListener('mousedown', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            startX = e.pageX;
            startWidth = th.offsetWidth;
            
            // Add visual feedback
            resizer.style.backgroundColor = 'rgba(0, 123, 255, 0.5)';
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';
            
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
        
        function onMouseMove(e) {
            const width = startWidth + (e.pageX - startX);
            if (width > 50) { // Minimum column width
                th.style.width = width + 'px';
                th.style.minWidth = width + 'px';
            }
        }
        
        function onMouseUp() {
            // Remove visual feedback
            resizer.style.backgroundColor = '';
            document.body.style.cursor = '';
            document.body.style.userSelect = '';
            
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
        }
    });
    
    console.log('Table column resize initialized');
});
