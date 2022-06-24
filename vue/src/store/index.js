import { createStore } from 'vuex'
import equipment from "./equipment.js"
import sets from "./sets.js"
import classes from "./classes.js"

export default createStore({
  state: {
  },
  modules: {
    equipment,sets,classes
  }
})
