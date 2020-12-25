import { combineReducers } from 'redux'

import mqttReducer from './features/mqtt/reducer'
import nowReducer from './features/clock/reducer'
import weatherReducer from './features/weather/reducer'
import trelloReducer from './features/trello/reducer'
import calendarReducer from './features/calendar/reducer'
import messagesReducer from './features/messages/reducer'
import sensorsReducer from './features/sensors/reducer'
import devicesReducer from './features/devices/reducer'
import roomsReducer from './features/rooms/reducer'
import presetsReducer from './features/preset/reducer'
import musicReducer from './features/music/reducer'


export default combineReducers({
    now: nowReducer,
    weather: weatherReducer,
    mqtt: mqttReducer,
    trello: trelloReducer,
    calendar: calendarReducer,
    messages: messagesReducer,
    sensors: sensorsReducer,
    devices: devicesReducer,
    rooms: roomsReducer,
    presets: presetsReducer,
    music: musicReducer,
})