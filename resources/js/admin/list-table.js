class ListTable 
{
    constructor(container='.admin-content-inner') 
    {
        const containerElement = document.querySelector(container);
        if (!containerElement) return;

        const el = containerElement.querySelector('.datalist-table');
        if(!el) return;

        let col = 0;
        if(el.classList.contains('datalist-freeze-2')) col = 2;
        if(el.classList.contains('datalist-freeze-3')) col = 3;
        if(el.classList.contains('datalist-freeze-4')) col = 4;
        if(col) {
            setTimeout(() => {
                this.updateStickyColumns(col);
            }, 100);
        }

        // Initialize row interactions
        this.initializeRowInteractions();
    }

    updateStickyColumns(col=2)
    {
        if (!window.matchMedia("(min-width: 760px)").matches) {
            return;
        }
        
        const table = document.querySelector(".uk-table");
        if (!table) return;

        const firstColWidth = table.querySelector("th:first-child, td:first-child").offsetWidth;
        const secondColWidth = table.querySelector("th:nth-child(2), td:nth-child(2)").offsetWidth;

        table.querySelectorAll("th:first-child, td:first-child").forEach(el => {
            el.style.left = "0px";
        });
        
        table.querySelectorAll("th:nth-child(2), td:nth-child(2)").forEach(el => {
            el.style.left = firstColWidth + "px";
        });
        
        if (col >= 3) {
            table.querySelectorAll("th:nth-child(3), td:nth-child(3)").forEach(el => {
                el.style.left = (firstColWidth + secondColWidth - 1) + "px";
            });
            
            const thirdColWidth = table.querySelector("th:nth-child(3), td:nth-child(3)").offsetWidth;
            
            if (col == 4) {
                table.querySelectorAll("th:nth-child(4), td:nth-child(4)").forEach(el => {
                    el.style.left = (firstColWidth + secondColWidth + thirdColWidth - 1) + "px";
                });
            }    
        }
    }

    initializeRowInteractions()
    {
        const table = document.querySelector(".uk-table tbody");
        if (!table) return;

        const rows = table.querySelectorAll("tr");
        
        rows.forEach((row, index) => {
            // Store original background color (for striped rows)
            const isStriped = index % 2 === 1;
            const originalColor = isStriped ? '#f8f8f8' : '#ffffff';
            
            // Hover effect
            row.addEventListener('mouseenter', function() {
                if (!this.classList.contains('row-selected')) {
                    this.querySelectorAll('td').forEach(td => {
                        td.style.backgroundColor = '#ffffee';
                        td.style.zIndex = '1';
                    });
                }
            });

            row.addEventListener('mouseleave', function() {
                if (!this.classList.contains('row-selected')) {
                    this.querySelectorAll('td').forEach(td => {
                        td.style.backgroundColor = '';
                        td.style.zIndex = '';
                    });
                }
            });

            // Click effect (toggle selection)
            row.addEventListener('click', function(e) {
                // Ignore clicks on action buttons/links
                if (e.target.closest('a, button')) {
                    return;
                }

                if (this.classList.contains('row-selected')) {
                    // Deselect: return to original color
                    this.classList.remove('row-selected');
                    this.querySelectorAll('td').forEach(td => {
                        td.style.backgroundColor = originalColor;
                        td.style.zIndex = '';
                    });
                } else {
                    // Select: apply selected color
                    this.classList.add('row-selected');
                    this.querySelectorAll('td').forEach(td => {
                        td.style.backgroundColor = '#ffffcc';
                        td.style.zIndex = '1';
                    });
                }
            });
        });
    }
}

document.addEventListener("DOMContentLoaded", function() {
    new ListTable();
});