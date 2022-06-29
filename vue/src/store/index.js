import { createStore } from 'vuex'
import equipment from "./equipment.js"
import sets from "./sets.js"
import classes from "./classes.js"
import user from "./user.js"
import employees from './employees.js'
import types from './types.js'

export default createStore({
  state: {
  },
  modules: {
    equipment,sets,classes,user,employees,types
  }
})
