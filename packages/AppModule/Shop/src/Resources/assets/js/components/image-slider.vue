<template>
    <transition name="slide">
        <div class="slider-content" v-if="images.length > 0">
            <ul class="slider-images">
                <li v-for="(image, index) in images" :key="index" v-bind:class="{'show': index==currentIndex}">
                    <a :href="image.slider_path">
                        <img class="slider-item" :alt="image.title" :src="image.path" />
                        <div class="show-content" v-bind:class="{'show': index==currentIndex}" :key="index" v-html="content[index]"></div>
                    </a>
                </li>
            </ul>

            <div class="slider-control" v-if="images_loaded">
                <span class="icon dark-left-icon slider-left" @click="changeIndexLeft"></span>
                <span class="icon light-right-icon slider-right" @click="changeIndexRight"></span>
            </div>
        </div>
    </transition>
</template>

<style lang="scss">
    .slider-control {
        direction: ltr;
    }

    .slide-enter-active {
        transition: all 0.2s cubic-bezier(0.55, 0.085, 0.68, 0.53);
    }

    .slide-leave-active {
        transition: all 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .slide-enter, .slide-leave-to {
        -webkit-transform: scaleY(0) translateZ(0);
        transform: scaleY(0) translateZ(0);
        opacity: 0;
    }
</style>

<script>
export default {
    props: {
        slides: {
            type: Array,
            required: true,
            default: () => [],
        },

        public_path: {
            type: String,
            required: true,
        }
    },

    data() {
        return {
            images: [],
            currentIndex: -1,
            content: [],
            current: false,
            images_loaded: false,
        };
    },

    mounted() {
        this.getProps();
    },

    methods: {
        getProps() {
            this.setProps();
        },

        setProps() {
            var self = this;

            this.slides.forEach(function(slider) {
                self.images.push({
                    'path': slider.image_url,
                    'title' : slider.title,
                    'slider_path': slider.slider_path ? slider.slider_path : null
                });

                self.content.push(slider.content);
            });

            this.currentIndex = 0;

            if (this.images.length == 0) {
                this.images.push = {'path': 'vendor/AppModule/shop/assets/images/banner.png'};
            } else {
                this.images_loaded = true;
            }
        },

        changeIndexLeft: function() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            } else if (this.currentIndex == 0) {
                this.currentIndex = this.images.length-1;
            }
        },

        changeIndexRight: function() {
            if (this.currentIndex < this.images.length-1) {
                this.currentIndex++;
            } else if (this.currentIndex == this.images.length-1) {
                this.currentIndex = 0;
            }
        }
    }
};
</script>