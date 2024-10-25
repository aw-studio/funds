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
                this.selectedTab = index;
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
                    event.preventDefault();
                }
            }
        };
    }
</script>
