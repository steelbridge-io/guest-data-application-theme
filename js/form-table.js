document.addEventListener('DOMContentLoaded', () => {
    const tableWrapper = document.querySelector('.table-wrapper');
    const tableScrollable = document.querySelector('.table-scrollable');
    const searchInput = document.getElementById('searchInput');
    const nextBtn = document.getElementById('nextMatch');
    const prevBtn = document.getElementById('prevMatch');
    const matchInfo = document.getElementById('matchInfo');
    let matches = [];
    let currentIndex = 0;

    if (tableScrollable && tableWrapper) {
        tableScrollable.addEventListener('scroll', () => {
            tableWrapper.scrollTop = tableScrollable.scrollTop;
        });
    }

    function highlightMatches(text) {
        const rows = document.querySelectorAll('#gda-table thead tr, #gda-table tbody tr');
        matches = [];
        rows.forEach((row) => {
            const cells = row.querySelectorAll('th, td');
            cells.forEach((cell) => {
                const originalHTML = cell.innerHTML;
                const originalText = cell.textContent.trim();

                cell.innerHTML = originalHTML.replace(/<\/?mark[^>]*>/g, '');

                if (text && originalText.toLowerCase().includes(text.toLowerCase())) {
                    const regex = new RegExp(`(${text})`, 'gi');

                    function highlight(node) {
                        let matchCount = 0;
                        const skipTags = ['script', 'style', 'button'];

                        for (let i = 0; i < node.childNodes.length; i++) {
                            const child = node.childNodes[i];
                            if (child.nodeType === 3) {
                                const data = child.data;
                                const parent = child.parentNode;
                                const match = regex.exec(data);

                                if (match) {
                                    const newNode = document.createElement('mark');
                                    newNode.textContent = match[0];
                                    const after = document.createTextNode(data.slice(match.index + match[0].length));
                                    parent.insertBefore(newNode, child.nextSibling);
                                    parent.insertBefore(after, newNode.nextSibling);
                                    child.data = data.slice(0, match.index);
                                    matches.push(parent);

                                    matchCount++;
                                }
                            } else if (!skipTags.includes(child.nodeName.toLowerCase())) {
                                matchCount += highlight(child);
                            }
                        }
                        return matchCount;
                    }

                    highlight(cell);
                }
            });
        });
        updateMatchInfo();
        scrollToMatch(currentIndex);
        reinitializePopovers();
    }

    function updateMatchInfo() {
        if (matches.length > 0) {
            matchInfo.textContent = `Match ${currentIndex + 1} of ${matches.length}`;
        } else {
            matchInfo.textContent = 'No matches found';
        }
    }

    function scrollToMatch(index) {
        if (matches.length > 0) {
            const match = matches[index];
            match.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
        }
    }

    function reinitializePopovers() {
        // Dispose of existing popovers
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(popoverTriggerEl => {
            const instance = bootstrap.Popover.getInstance(popoverTriggerEl);
            if (instance) {
                instance.dispose();
            }
        });

        // Reinitialize popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                trigger: 'focus',
                html: true,
            });
        });
    }

    searchInput.addEventListener('keyup', function () {
        currentIndex = 0;
        highlightMatches(searchInput.value.toLowerCase());
    });

    nextBtn.addEventListener('click', function () {
        if (matches.length > 0) {
            currentIndex = (currentIndex + 1) % matches.length;
            scrollToMatch(currentIndex);
            updateMatchInfo();
        }
    });

    prevBtn.addEventListener('click', function () {
        if (matches.length > 0) {
            currentIndex = (currentIndex - 1 + matches.length) % matches.length;
            scrollToMatch(currentIndex);
            updateMatchInfo();
        }
    });

    reinitializePopovers();
});