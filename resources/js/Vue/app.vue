<template>
    <div class="container-main">
        <div class="header-main">
            <div class="icon">
                <img :src="icon" class="icon-jp">
            </div>
            <div class="">
                <h3 class="header-text">JAPAN TRAVEL & WEATHER FORECAST</h3>
            </div>
        </div>
        <div class="container-details">
            <div class="weather-main">
                <div class="weather-items">
                    <div class="weather-temp">
                        <img :src="'https://openweathermap.org/img/wn/'+weather.icon+'@2x.png'">
                        <span>{{ weather.temp }}&deg;C</span>
                    </div>
                    <div class="weather-description">
                        <span>{{ weather.description }}</span>
                    </div>
                    <div class="weather-title">
                        <div class="container-left">
                            <i class="fa fa-circle-chevron-left hover" @click="prev()"></i>
                        </div>
                        <div class="container-city">
                            <select @change="onChange()" v-model="selectedCity">
                                <option v-for="city in cities">
                                    {{ city }}
                                </option>
                            </select>
                        </div>
                        <div class="container-right">
                            <i class="fa fa-circle-chevron-right hover" @click="next()"></i>
                        </div>
                    </div>
                    <div class="weather-details">
                        <div class="weather-other">
                            <div class="weather-value">
                                {{ weather.humidity  }}&percnt;
                            </div>
                            <div class="weather-text">
                                <span>Humidity</span>
                            </div>
                        </div>
                        <div class="weather-other">
                            <div class="weather-value">
                                {{ weather.feels_like  }}&deg;C
                            </div>
                            <div class="weather-text">
                                <span>Feels Like</span>
                            </div>
                        </div>
                        <div class="weather-other">
                            <div class="weather-value">
                                {{ weather.temp_max  }}&deg;C
                            </div>
                            <div class="weather-text">
                                <span>Max</span>
                            </div>
                        </div>
                        <div class="weather-other">
                            <div class="weather-value">
                                {{ weather.temp_min  }}&deg;C
                            </div>
                            <div class="weather-text">
                                <span>Min</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="other-details">
                    <div class="tz-details">
                        <label>UTC {{ weather.timezone }}</label>
                    </div>
                    <div class="other-details-item">
                        <div class="sunrise">
                            <i class="fa fa-5x fa-sun"></i>
                            <label>Sunrise at {{ weather.sunrise }}</label>
                        </div>
                        <div class="sunset">
                            <i class="fa fa-5x fa-moon"></i>
                            <label>Sunset at {{ weather.sunset }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="details-main">
                <div class="details-items">
                    <div class="details-title">
                       Nearby Places in {{ selectedCity }}
                    </div>
                    <div class="details-img">
                        <Carousel :autoplay="2000" :wrap-around="true">
                            <Slide v-for="photo in imgDetails" :key="photo.url">
                                <img class="carousel__item" :src="photo.url"  alt="Photos"/>
                            </Slide>

                            <template #addons>
                            <Navigation />
                            <Pagination />
                            </template>
                        </Carousel>
                    </div>
                    <div class="details-desc">
                        <div class="container-left-places">
                            <i class="fa fa-2x fa-chevron-left hover" @click="prevPlace()"></i>
                        </div>
                        <div class="container-place-text">
                            <div class="header-place-text">
                                {{ place.place ? place.place.name : "" }}
                            </div>
                            <div class="place-details">
                                <div>
                                    <label>Category: {{ place.place ? place.place.categories[0].name : "" }}</label>
                                </div>
                                <div>
                                    <label>Address: {{ place.place ? place.place.location.formatted_address : "" }}</label>
                                </div>
                                <div>
                                    <label>Local: {{ place.place ? place.place.location.locality : "" }}</label>
                                </div>
                                <div>
                                    <label>Region: {{ place.place ? place.place.location.region : "" }}</label>
                                </div>
                                <div>
                                    <label>Post Code: {{ place.place ? place.place.location.postcode : "" }}</label>
                                </div>
                            </div>
                            <div class="pager">
                                {{ countPlaces + 1 }} of {{ totalPlaces }}
                            </div>
                        </div>
                        <div class="container-right-places">
                            <i class="fa fa-2x fa-chevron-right hover" @click="nextPlace()"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Carousel, Pagination, Slide } from 'vue3-carousel'
import moment from 'moment-timezone'
import icon from '../../img/3925253.png'
export default {
    data () {
        return {
            count: 0,
            countPlaces: 0,
            totalPlaces: 0,
            icon: icon,
            cities: [
                "Tokyo",
                "Yokohama",
                "Kyoto",
                "Osaka",
                "Sapporo",
                "Nagoya",
            ],
            selectedCity: "Tokyo",
            weather: {
                feels_like: "",
                humidity: "",
                pressure: "",
                temp: "",
                temp_max: "",
                temp_min: "",
                description: "",
                main: "",
                deg: "",
                speed: "",
                sunrise: "",
                sunset: "",
                timezone: "",
                icon: "",
            },
            place: {

            },
            photos: {

            },
            imgDetails: []
        }
     },
     components: {
        Carousel,
        Slide,
        Pagination
    },
     methods: {
        onChange: async function() {
            const API_KEY = import.meta.env.VITE_FOUR_SQUARE_API_KEY
            const city = this.selectedCity
            const response = await axios.get(`/api/places/${city}`);
            const places = response.data.places.data.results;
            const weather = response.data.weather.data;

            this.weather.feels_like = Math.ceil(weather.main.feels_like)
            this.weather.humidity = Math.ceil(weather.main.humidity)
            this.weather.pressure = Math.ceil(weather.main.pressure)
            this.weather.temp = Math.ceil(weather.main.temp)
            this.weather.temp_max = Math.ceil(weather.main.temp_max)
            this.weather.temp_min = Math.ceil(weather.main.temp_min)
            this.weather.description = weather.weather[0].description
            this.weather.main = weather.weather[0].main
            this.weather.deg = weather.wind.deg
            this.weather.speed = weather.wind.speed
            this.weather.icon = weather.weather[0].icon
            this.weather.sunrise = moment.utc(weather.sys.sunrise,'X').add(weather.timezone,'seconds').format('HH:mm')
            this.weather.sunset = moment.utc(weather.sys.sunset,'X').add(weather.timezone,'seconds').format('HH:mm')
            this.weather.timezone = moment.tz('Asia/Tokyo').format('Z z')

            const index = this.cities.indexOf(city);
            this.count = index

            this.totalPlaces = places.length
            this.place = places[this.countPlaces]
            const fsq_id = this.place.place.fsq_id

            const options = {
                headers: {
                    accept: 'application/json',
                    authorization: API_KEY
                }
            }

            const photos = await axios.get(`https://api.foursquare.com/v3/places/${fsq_id}/photos`, options);
            this.photos = photos.data

            photos.data.forEach(element => {
                let prefix = element.prefix
                let suffix = element.suffix
                let width = element.width
                let height = element.height

                let photoDetails = {
                    url : prefix+"500x300"+suffix,
                    width : width,
                    height : height
                }

                this.imgDetails.push(photoDetails)
            });
        },
        next() {
            this.count++
            if(this.count == 6) this.count = 0
            this.selectedCity = this.cities[this.count]
            this.onChange()
            this.imgDetails = [];
        },
        prev() {
            this.count--
            if(this.count == -1) this.count = 5
            this.selectedCity = this.cities[this.count]
            this.onChange()
            this.imgDetails = [];
        },
        nextPlace() {
            this.countPlaces++
            if(this.countPlaces == 5) this.countPlaces = 0
            this.onChange();
            this.imgDetails = [];
        },
        prevPlace() {
            this.countPlaces--
            if(this.countPlaces == -1) this.countPlaces = 4
            this.onChange();
            this.imgDetails = [];
        }

    },
    created: function () {
       this.onChange()
    },
}
</script>
