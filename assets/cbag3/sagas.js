import { all } from 'redux-saga/effects'

import watchWeatherForecast from './features/weather/sagas'
import trelloSagas from './features/trello/sagas'
import { watchCalendarUpdate } from './features/calendar/sagas'
import { watchSensorDataUpdate } from './features/sensors/sagas'
import devicesSagas from './features/devices/sagas'
import presetSagas from './features/preset/sagas'
import musicSagas from './features/music/sagas'


export default function* rootSaga() {
    yield all([
        watchWeatherForecast(),
        trelloSagas(),
        watchCalendarUpdate(),
        watchSensorDataUpdate(),
        devicesSagas(),
        presetSagas(),
        musicSagas(),
    ])
}