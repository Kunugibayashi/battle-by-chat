<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper" @click.self="$emit('close')">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header"></slot>
                        <button @click="$emit('close')" class="modal-close-button" type="button">×</button>
                    </div>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</script>
<script>
Vue.component("modal", {
    template: "#modal-template"
});
</script>
