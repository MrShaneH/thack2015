using HotelService;
using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;

namespace API.Controllers
{
    public class HotelController : ApiController
    {
        // GET api/values
        public HotelSearchResponse Get(string latitude, string longitude, int radius, string startDate)
        {
            var hotelRequest = new HotelSearchRequest()
            {
                Radius=radius,
                StartDate=DateTime.ParseExact(startDate, "yyyy-MM-dd", CultureInfo.InvariantCulture),
                Latitude = latitude,
                Longitude = longitude
            };
            var hotelService = new HotelBedsHotelService();
            var response = hotelService.Search(hotelRequest);
            return response;
        }

        // GET api/values/5
        public string Get(int id)
        {
            return "value";
        }

        // POST api/values
        public void Post([FromBody]string value)
        {
        }

        // PUT api/values/5
        public void Put(int id, [FromBody]string value)
        {
        }

        // DELETE api/values/5
        public void Delete(int id)
        {
        }
    }
}
