cs50diabetes
============

## Final project for Harvard CS50 class (via edX), Intensive Introduction to Computer Science

### Authors:
  * Lisa Lovchik (Georgiades)
  * Steve Georgiades

### Background:
This was a collaborative project to create a custom web app geared toward type 1 diabetics. This included an API to FatSecret to:
  1. find nutritional data for a large database of foods
  1. track users' meals
  1. track users' weight over time
  
Authentication was implemented so that new users could register, and returning users could log in and automatically authenticate to FatSecret with a unique token. Carbohydrate information was extracted from the FatSecret nutritional data, and used in concert with custom code to:
  1. calculate and track total carbohydrate intake per meal
  1. calculate and track appropriate insulin dosages (boluses, for insulin pumps), based on:
      1. Carb Ratio in gm/U (3-150)
      1. Sensitivity in mg/dL per U (10-400)
      1. BG Target (blood glucose target range) in mg/dL (60-250)
  1. track blood glucose trends
  1. find averages and create charts for items 1 to 3

__Note__: *We were up against a tight deadline, so there wasn't time for proper code tidying and refactoring.*
