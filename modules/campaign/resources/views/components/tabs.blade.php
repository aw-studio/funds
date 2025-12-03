<div x-data="tabs()">
    <div
        role="tablist"
        aria-labelledby="tablist-1"
        class="automatic"
    >
        {{ $buttons }}
    </div>

    <div class="tab-panels">
        {{ $panels }}
    </div>
</div>

<script>
    function tabs() {
        return {
            selectedTab: 0,
            selectTab(index) {
                this.updateTabSelection(index);
            },
            isSelected(index) {
                return this.selectedTab === index ? 'true' : 'false';
            },
            onKeydown(event) {
                const tabCount = document.querySelectorAll('[role="tab"]').length;
                const keyMap = {
                    ArrowLeft: () => this.selectedTab = (this.selectedTab === 0) ? tabCount - 1 : this.selectedTab -
                        1,
                    ArrowRight: () => this.selectedTab = (this.selectedTab === tabCount - 1) ? 0 : this
                        .selectedTab + 1,
                    Home: () => this.selectedTab = 0,
                    End: () => this.selectedTab = tabCount - 1,
                };

                if (keyMap[event.key]) {
                    keyMap[event.key]();
                    this.updateImageSizes();
                    event.preventDefault();
                }

                this.updateTabFocusAndHash();
            },
            updateImageSizes() {
                const activePanel = document.querySelector('.tab-panels div[tabindex="' + this.selectedTab + '"]');
                if (activePanel) {
                    const images = activePanel.querySelectorAll('img');
                    setTimeout(() => {
                        images.forEach(image => {
                            const rect = image.getBoundingClientRect();
                            image.setAttribute('width', rect.width);
                            image.setAttribute('height', rect.height);
                            image.setAttribute('sizes', `${rect.width}px`);
                        });
                    }, 20);
                }
            },
            updateTabSelection(index) {
                this.selectedTab = index;
                this.updateImageSizes();
                this.updateTabFocusAndHash();
            },
            updateTabFocusAndHash() {
                const tabButton = document.querySelector(`[tabindex="${this.selectedTab}"]`);
                if (tabButton) {
                    tabButton.focus();
                    window.location.hash = tabButton.getAttribute('slug');
                }
            },
            init() {
                const hash = window.location.hash.substring(1);
                if (hash) {
                    const tabButton = document.querySelector(`[slug="${hash}"]`);
                    if (tabButton) {
                        const index = parseInt(tabButton.getAttribute('tabindex'), 10);
                        if (!isNaN(index)) {
                            this.selectedTab = index;
                        }
                    }
                }
                this.updateImageSizes();
            },
        };
    }
</script>
