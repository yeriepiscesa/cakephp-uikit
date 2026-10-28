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
        
        rows.forEach((row) => {
            row.addEventListener('click', function(e) {
                if (e.target.closest('a, button, input, select, textarea, label')) return;
                this.classList.toggle('row-selected');
            });
        });
    }
}

document.addEventListener("DOMContentLoaded", function() {
    new ListTable();
});