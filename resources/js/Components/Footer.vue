<script setup>
import ApplicationLogo from './ApplicationLogo.vue'
</script>

<template>
    <footer class="relative bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 20px 20px;"></div>
        </div>
        
        <div class="relative">
            <!-- Main Footer Content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
                <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-8">
                    <!-- Brand Section -->
                    <div class="lg:col-span-1 mb-8 lg:mb-0">
                        <div class="mb-6">
                            <ApplicationLogo class="h-10 w-auto mb-4" />
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent mb-3">
                                Go Sedekah
                            </h3>
                            <p class="text-gray-300 leading-relaxed">
                                Empowering communities through compassionate giving. Join us in making a difference, one donation at a time.
                            </p>
                        </div>
                        
                        <!-- Social Media Links -->
                        <div class="flex space-x-4">
                            <a href="#" class="group bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-all duration-200 hover:scale-110">
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="group bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-all duration-200 hover:scale-110">
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="group bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-all duration-200 hover:scale-110">
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.219-.359-1.219c0-1.142.662-1.995 1.488-1.995.219 0 .824.219.824 1.219 0 .735-.468 1.83-.711 2.846-.199.844.422 1.488 1.254 1.488 1.51 0 2.67-1.59 2.67-3.891 0-2.035-1.463-3.457-3.553-3.457-2.423 0-3.844 1.818-3.844 3.695 0 .735.281 1.51.633 1.937.07.07.07.141.053.219-.059.281-.191.937-.219 1.063-.035.141-.141.172-.281.105-1.051-.482-1.711-1.996-1.711-3.219 0-2.67 1.941-5.129 5.598-5.129 2.953 0 5.248 2.107 5.248 4.926 0 2.939-1.854 5.309-4.432 5.309-.867 0-1.676-.457-1.957-1.016l-.531 2.035c-.193.754-.715 1.699-1.07 2.277A11.987 11.987 0 0 0 24.003 11.987C24.003 5.367 18.637.001 12.017.001z"/>
                                </svg>
                            </a>
                            <a href="#" class="group bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-all duration-200 hover:scale-110">
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.543 2.173c3.24.001 5.766 2.593 5.766 5.796 0 3.227-2.522 5.848-5.766 5.848s-5.766-2.621-5.766-5.848c0-3.203 2.526-5.795 5.766-5.796zM12.543 0c-4.417 0-8 3.542-8 7.919 0 6.844 7.302 15.327 7.654 15.69a.538.538 0 0 0 .692 0c.352-.363 7.654-8.846 7.654-15.69C20.543 3.542 16.96 0 12.543 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="mb-8 lg:mb-0">
                        <h5 class="text-lg font-bold mb-6 bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Quick Links
                        </h5>
                        <ul class="space-y-3">
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    How to Donate
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Request Help
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Success Stories
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Transparency Report
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="mb-8 lg:mb-0">
                        <h5 class="text-lg font-bold mb-6 bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Support
                        </h5>
                        <ul class="space-y-3">
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    FAQ
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Contact Us
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Help Center
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Community Guidelines
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h5 class="text-lg font-bold mb-6 bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Get in Touch
                        </h5>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-indigo-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-gray-300">
                                    Kuala Lumpur, Malaysia
                                </span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-indigo-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <a href="mailto:go.sedekah0711@gmail.com" class="text-gray-300 hover:text-white transition-colors duration-200">
                                    go.sedekah0711@gmail.com
                                </a>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-indigo-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <a href="tel:+60123456789" class="text-gray-300 hover:text-white transition-colors duration-200">
                                    +60 12-345 6789
                                </a>
                            </div>
                        </div>

                        <!-- Newsletter Signup -->
                        <div class="mt-6 p-4 bg-white/5 rounded-xl border border-white/10">
                            <h6 class="text-sm font-semibold text-white mb-3">Stay Updated</h6>
                            <div class="flex">
                                <input 
                                    type="email" 
                                    placeholder="Enter your email"
                                    class="flex-1 px-3 py-2 bg-white/10 border border-white/20 rounded-l-lg text-white placeholder-gray-400 text-sm focus:outline-none focus:border-indigo-400"
                                />
                                <button class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-r-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-white/10 bg-black/20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="text-sm text-gray-300">
                            © 2024 Go Sedekah. All rights reserved.
                        </div>
                        <div class="flex space-x-6 text-sm">
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Privacy Policy</a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Terms of Service</a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Cookie Policy</a>
                        </div>
                        <div class="text-sm text-gray-400">
                            Made with 
                            <span class="text-red-400 mx-1">♥</span> 
                            for the community
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
