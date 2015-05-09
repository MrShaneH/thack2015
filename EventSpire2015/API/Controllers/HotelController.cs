using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNet.Mvc;
using HotelService;

namespace API.Controllers
{
    [Route("api/[controller]")]
    public class HotelController : Controller
    {
        // POST api/values
        [HttpGet]
        public JsonResult Get(string longitude, string latitude, string radius, string startDate)
        {
            var searchRequest = new HotelSearchRequest()
            {
                Longitude = longitude,
                Latitude = latitude,
                Radius = Convert.ToInt32(radius),
                StartDate = DateTime.Now
            };
            var hotelService = new HotelBedsHotelService();
            var searchResponse = hotelService.Search(searchRequest);

            return Json(searchResponse);
        }

    }
}
